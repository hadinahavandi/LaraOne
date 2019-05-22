<?php
namespace App\Http\Controllers\sas\API;
use App\Http\Controllers\sas\Classes\Unit;
use App\models\sas\sas_device;
use App\models\sas\sas_request;
use App\Http\Controllers\Controller;
use App\models\sas\sas_requestmessage;
use App\models\sas\sas_requeststatustrack;
use App\models\sas\sas_requesttype;
use App\models\sas\sas_requestunittrack;
use App\models\sas\sas_status;
use App\models\sas\sas_unit;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use App\User;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequestController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.request.insert'))
            throw new AccessDeniedHttpException();

		$InputRequesttype=$request->input('requesttype');
		$InputReceiverUnit=$request->input('receiverunit');
//        return $InputReceiverUnit;
		$reqT=sas_requesttype::find($InputRequesttype);
		$Priority=$reqT->priority;
		$InputDevice=$request->input('device');
		if($InputDevice==null || $InputDevice<1)
		    $InputDevice=0;
		$InputDescriptionte=$request->input('descriptionte');
		$InputAttachmentflu=$request->file('attachmentflu');
        if($InputAttachmentflu!=null){
            $InputAttachmentflu->move('img/',$InputAttachmentflu->getClientOriginalName());
            $InputAttachmentflu='img/'.$InputAttachmentflu->getClientOriginalName();
        }
        else
        {
            $InputAttachmentflu='';
        }
		$Status=1;
        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        $UserType=$UnitInfo["usertype"];
        $Unit=$UnitInfo["unit"];
        $CurrentUnit=$Unit->id;
        $adminAcceptTime='0';
        $securityAcceptTime='0';
        $finalSendTime='0';
        if($UserType==Unit::$USERTYPE_ADMIN)
            $adminAcceptTime=time();
        if($UserType==Unit::$USERTYPE_SECURITY)
            $securityAcceptTime=time();
        $SendingToFinal=$this->isPassedToFinalSend($Unit,$reqT,$UserType);
        if($SendingToFinal)
        {
            if(Unit::isUnitInUserNextUnits($InputReceiverUnit))
            {
                $CurrentUnit=$InputReceiverUnit;
                $finalSendTime=time();
            }
        }
		$InputLetternumber=$request->input('letternumber');
		$InputLetterdate=$request->input('letterdate');
		$Request = sas_request::create(['requesttype_fid'=>$InputRequesttype,'device_fid'=>$InputDevice,'description_te'=>$InputDescriptionte,'priority'=>$Priority,'attachment_flu'=>$InputAttachmentflu,'status_fid'=>$Status,'sender__unit_fid'=>$Unit->id,'receiver__unit_fid'=>$InputReceiverUnit,'current__unit_fid'=>$CurrentUnit,'adminacceptance_time'=>$adminAcceptTime,'securityacceptance_time'=>$securityAcceptTime,'fullsend_time'=>$finalSendTime,'finalcommit_time'=>'0','letternumber'=>$InputLetternumber,'letter_date'=>$InputLetterdate,'sender__user_fid'=>$UserID,'deletetime'=>-1]);
		if($SendingToFinal)
        {
            sas_requestunittrack::create(['request_fid'=>$Request->id,'unit_fid'=>$CurrentUnit,'user_fid'=>$UserID]);
        }
		return response()->json(['Data'=>$Request], 201);
	}
	public function setUserApproval($id,Request $request)
    {
//        if(!Bouncer::can('sas.request.approvesend'))
//            throw new AccessDeniedHttpException();
        $Request = new sas_request();
        $Request = $Request->find($id);

        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        $UserType=$UnitInfo["usertype"];
        $Unit=$UnitInfo["unit"];

        if($UserType==Unit::$USERTYPE_ADMIN)
            $Request->adminacceptance_time=time();
        if($UserType==Unit::$USERTYPE_SECURITY)
            $Request->securityacceptance_time=time();
        $SendingToFinal=$this->isPassedToFinalSend($Unit,$Request->requesttype(),$UserType);
        if($SendingToFinal)
        {
            if(Unit::isUnitInUserNextUnits($Request->receiver__unit_fid))
            {
                $Request->fullsend_time=time();
                $Request->current__unit_fid=$Request->receiver__unit_fid;
            }
        }
        $Request->save();

    }
	private function isPassedToFinalSend($Unit,sas_requesttype $request,$UserType)
    {

        $PassedAdminApproval=((!$Unit->is_needsadminapproval)|| $UserType==Unit::$USERTYPE_ADMIN ||$UserType==Unit::$USERTYPE_SECURITY);
        $PassedSecurityApproval=((!$request->is_needssecurityacceptance) || $UserType==Unit::$USERTYPE_SECURITY);
        if($PassedAdminApproval && $PassedSecurityApproval)
            return true;
        return false;
    }
    public function changePriority($id,Request $request)
    {
//        if(!Bouncer::can('sas.request.changepriority'))
//            throw new AccessDeniedHttpException();
        $UnitInfo=Unit::getUserUnitAndType();
        $Unit=$UnitInfo["unit"];
        $InputPriority=$request->get('priority');
        $Request = new sas_request();
        $Request = $Request->find($id);
        if($Request->current__unit_fid==$Unit->id)
        {
            $Request->priority=$InputPriority;
            $Request->save();
        }

        return response()->json(['Data'=>$Request], 202);

    }
    public function sendToNext($id,Request $request)
    {

//        if(!Bouncer::can('sas.request.changepriority'))
//            throw new AccessDeniedHttpException();
        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        $Unit=$UnitInfo["unit"];

        $InputReceiverUnit=$request->get('receiver__unit_fid');
        $Request = new sas_request();
        $Request = $Request->find($id);
        if($Request->current__unit_fid==$Unit->id)
        {
            if(Unit::isUnitInUserNextUnits($InputReceiverUnit))
            {
                $Request->current__unit_fid=$InputReceiverUnit;
                sas_requestunittrack::create(['request_fid'=>$Request->id,'unit_fid'=>$InputReceiverUnit,'user_fid'=>$UserID]);
                $Request->save();
            }
        }
        else
            return response()->json(['Error'=>$InputReceiverUnit], 202);


        return response()->json(['Data'=>$Request], 202);
    }

    public function setStatus($id,Request $request)
    {
//        if(!Bouncer::can('sas.request.changepriority'))
//            throw new AccessDeniedHttpException();
        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        $Unit=$UnitInfo["unit"];

        $InputStatus=$request->get('status_fid');
        $Status=sas_status::find($InputStatus);
        if($Status!=null)
        {
            $Request = new sas_request();
            $Request = $Request->find($id);
            if($Request->current__unit_fid==$Unit->id)
            {
                $Request->status_fid=$InputStatus;
                if($Status->is_commited)
                    $Request->finalcommit_time=time();
                $Status=sas_requeststatustrack::create(['request_fid'=>$Request->id,'status_fid'=>$InputStatus,'user_fid'=>$UserID]);
                $Request->save();
            }

            return response()->json(['Data'=>$Request,"status"=>$InputStatus,"SSS"=>[$Request->current__unit_fid,$Unit->id]], 202);
        }

    }
    public function addMessage($id,Request $request)
    {
//        if(!Bouncer::can('sas.request.changepriority'))
//            throw new AccessDeniedHttpException();
        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        $Unit=$UnitInfo["unit"];

        $InputMessage=$request->get('message');
        $Request = new sas_request();
        $Request = $Request->find($id);
        $Message=['nothing'];
        if($Request->sender__unit_fid==$Unit->id || $Request->current__unit_fid==$Unit->id)
        {
            $Message=sas_requestmessage::create(['request_fid'=>$Request->id,'message_te'=>$InputMessage,'unit_fid'=>$Unit->id,'user_fid'=>$UserID]);
        }

        return response()->json(['Data'=>$Message], 202);

    }
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.request.edit'))
            throw new AccessDeniedHttpException();
    
        $InputRequesttype=$request->get('requesttype');
        $InputDevice=$request->get('device');
        $InputDescriptionte=$request->get('descriptionte');
        $InputPriority=$request->get('priority');
        $InputAttachmentflu=$request->file('attachmentflu');
        if($InputAttachmentflu!=null){
            $InputAttachmentflu->move('img/',$InputAttachmentflu->getClientOriginalName());
            $InputAttachmentflu='img/'.$InputAttachmentflu->getClientOriginalName();
        }
        else
        { 
            $InputAttachmentflu='';
        }
        $InputStatus=$request->get('status');
        $InputSenderunit=$request->get('senderunit');
        $InputCurrentunit=$request->get('currentunit');
        $InputAdminacceptancetime=$request->get('adminacceptancetime');
        $InputSecurityacceptancetime=$request->get('securityacceptancetime');
        $InputFullsendtime=$request->get('fullsendtime');
        $InputLetternumber=$request->get('letternumber');
        $InputLetterdate=$request->get('letterdate');
        $InputSenderuser=$request->get('senderuser');
        $Request = new sas_request();
        $Request = $Request->find($id);
        $Request->requesttype_fid=$InputRequesttype;
        $Request->device_fid=$InputDevice;
        $Request->description_te=$InputDescriptionte;
        $Request->priority=$InputPriority;
        if($InputAttachmentflu!=null)
            $Request->attachment_flu=$InputAttachmentflu;
        $Request->status_fid=$InputStatus;
        $Request->sender__unit_fid=$InputSenderunit;
        $Request->current__unit_fid=$InputCurrentunit;
        $Request->adminacceptance_time=$InputAdminacceptancetime;
        $Request->securityacceptance_time=$InputSecurityacceptancetime;
        $Request->fullsend_time=$InputFullsendtime;
        $Request->letternumber=$InputLetternumber;
        $Request->letter_date=$InputLetterdate;
        $Request->sender__user_fid=$InputSenderuser;
        $Request->save();
        return response()->json(['Data'=>$Request], 202);
    }
    public function list(Request $request)
    {
//        Bouncer::allow('admin')->to('sas.request.insert');
//        Bouncer::allow('admin')->to('sas.request.edit');
//        Bouncer::allow('admin')->to('sas.request.list');
//        Bouncer::allow('admin')->to('sas.request.view');
//        Bouncer::allow('admin')->to('sas.request.delete');
//
        Bouncer::allow('type1_unituser')->to('sas.request.insert');
        Bouncer::allow('type1_unituser')->to('sas.request.list');
        Bouncer::allow('type1_unituser')->to('sas.request.view');
        Bouncer::allow('type1_unituser')->to('sas.device.insert');
        Bouncer::allow('type1_unituser')->to('sas.device.list');
        Bouncer::allow('type1_unituser')->to('sas.device.view');
        Bouncer::allow('type1_unituser')->to('sas.device.edit');

        Bouncer::allow('type1_unituser')->to('sas.request.outbox');
        Bouncer::allow('type2_unituser')->to('sas.request.outbox');

        Bouncer::allow('type2_unituser')->to('sas.request.inbox');
        Bouncer::allow('type3_unituser')->to('sas.request.inbox');
//
//        Bouncer::allow('unitadmin')->to('sas.request.insert');
//        Bouncer::allow('unitadmin')->to('sas.request.list');
//        Bouncer::allow('unitadmin')->to('sas.request.view');
//        Bouncer::allow('unitadmin')->to('sas.device.insert');
//        Bouncer::allow('unitadmin')->to('sas.device.list');
//        Bouncer::allow('unitadmin')->to('sas.device.view');
//        Bouncer::allow('unitadmin')->to('sas.device.edit');
//
//        Bouncer::allow('unitsecurity')->to('sas.request.insert');
//        Bouncer::allow('unitsecurity')->to('sas.request.list');
//        Bouncer::allow('unitsecurity')->to('sas.request.view');
//        Bouncer::allow('unitsecurity')->to('sas.device.insert');
//        Bouncer::allow('unitsecurity')->to('sas.device.list');
//        Bouncer::allow('unitsecurity')->to('sas.device.view');
//        Bouncer::allow('unitsecurity')->to('sas.device.edit');
        Bouncer::allow('type2_unitsecurity')->to('sas.request.inbox');
        Bouncer::allow('type3_unitsecurity')->to('sas.request.inbox');


        Bouncer::allow('type1_unitadmin')->to('sas.request.outbox');
        Bouncer::allow('type1_unitadmin')->to('sas.request.insert');
        Bouncer::allow('type1_unitadmin')->to('sas.request.list');
        Bouncer::allow('type1_unitadmin')->to('sas.device.insert');
        Bouncer::allow('type1_unitadmin')->to('sas.device.list');
        Bouncer::allow('type1_unitadmin')->to('sas.device.view');
        Bouncer::allow('type1_unitadmin')->to('sas.device.edit');
        Bouncer::allow('type1_unitadmin')->to('sas.request.approve');


        Bouncer::allow('type2_unitadmin')->to('sas.request.outbox');
        Bouncer::allow('type2_unitadmin')->to('sas.request.insert');
        Bouncer::allow('type2_unitadmin')->to('sas.request.list');
        Bouncer::allow('type2_unitadmin')->to('sas.device.insert');
        Bouncer::allow('type2_unitadmin')->to('sas.device.list');
        Bouncer::allow('type2_unitadmin')->to('sas.device.view');
        Bouncer::allow('type2_unitadmin')->to('sas.device.edit');
        Bouncer::allow('type2_unitadmin')->to('sas.request.inbox');
        Bouncer::allow('type2_unitadmin')->to('sas.request.approve');
        Bouncer::allow('type2_unitadmin')->to('sas.request.change');


        Bouncer::allow('type3_unitadmin')->to('sas.request.inbox');
        Bouncer::allow('type3_unitadmin')->to('sas.request.list');
        Bouncer::allow('type3_unitadmin')->to('sas.request.change');


        //if(!Bouncer::can('sas.request.list'))
            //throw new AccessDeniedHttpException();
        $RequestQuery = sas_request::where('id','>=','0');
        return $this->getData($request,$RequestQuery);
    }

    public function listOutBox(Request $request)
    {
        //if(!Bouncer::can('sas.request.list'))
        //throw new AccessDeniedHttpException();

        $UnitInfo=Unit::getUserUnitAndType();
        $UserType=$UnitInfo["usertype"];
        $Unit=$UnitInfo["unit"];
        $RequestQuery = sas_request::where('sender__unit_fid','=',$Unit->id);
        return $this->getData($request,$RequestQuery);
    }
    public function listInBox(Request $request)
    {
        //if(!Bouncer::can('sas.request.list'))
        //throw new AccessDeniedHttpException();

        $UnitInfo=Unit::getUserUnitAndType();
        $UserType=$UnitInfo["usertype"];
        $Unit=$UnitInfo["unit"];
        $reqT=new sas_requestunittrack();
        $RequestQuery = sas_request::join('sas_requestunittrack', function ($join) use($Unit) {
            $join->on('sas_requestunittrack.request_fid', '=', 'sas_request.id')->orWhere('sas_request.current__unit_fid', '=', $Unit->id);
        })->where('sas_requestunittrack.unit_fid',"=",$Unit->id);
//        echo dd(DB::getQueryLog());

        return $this->getData($request,$RequestQuery);
    }
    public function listNeedToApproveBox(Request $request)
    {
        //if(!Bouncer::can('sas.request.list'))
        //throw new AccessDeniedHttpException();

        $UnitInfo=Unit::getUserUnitAndType();
        $UserType=$UnitInfo["usertype"];
        $Unit=$UnitInfo["unit"];

        $RequestQuery = sas_request::where('sender__unit_fid','=',$Unit->id)->where('fullsend_time','<=','0');
        if($UserType==Unit::$USERTYPE_ADMIN)
            $RequestQuery=$RequestQuery->where('adminacceptance_time','<=','0');
        elseif ($UserType==Unit::$USERTYPE_SECURITY)
            $RequestQuery=$RequestQuery->where('adminacceptance_time','>','0')->where('securityacceptance_time','<=','0');
//        echo dd(DB::getQueryLog());

        return $this->getData($request,$RequestQuery);
    }
    public function listCurrentBox(Request $request)
    {
        //if(!Bouncer::can('sas.request.list'))
        //throw new AccessDeniedHttpException();

        $UnitInfo=Unit::getUserUnitAndType();
        $Unit=$UnitInfo["unit"];
        $RequestQuery = sas_request::where('sender__unit_fid','!=',$Unit->id)->where('current__unit_fid','=',$Unit->id);
        return $this->getData($request,$RequestQuery);
    }
    private function getStatusStats(Request $request,Builder $QueryBuilder)
    {
        $Result=[];
        $Statuses=sas_status::all();
        foreach($Statuses as $Status)
        {
            $QueryBuilder2=clone $QueryBuilder;
            $StatusArray=$Status->toArray();
            $StatusArray['count']=$QueryBuilder2->where('sas_request.status_fid',"=",$Status->id)->get()->count();
            array_push($Result,$StatusArray);
        }
        return response()->json(['Data'=>$Result], 200);
    }
    private function getRequestTypeStats(Request $request,Builder $QueryBuilder)
    {
        $Result=[];
        $Types=sas_requesttype::all();
        foreach($Types as $Type)
        {
            $QueryBuilder2=clone $QueryBuilder;
            $StatusArray=$Type->toArray();
            $StatusArray['count']=$QueryBuilder2->where('sas_request.requesttype_fid',"=",$Type->id)->get()->count();
            array_push($Result,$StatusArray);
        }
        return response()->json(['Data'=>$Result], 200);
    }
    private function getData(Request $request,Builder $QueryBuilder)
    {

        if($request->get("__statusstats")!=null)
            return $this->getStatusStats($request,$QueryBuilder);
        elseif($request->get("__typestats")!=null)
            return $this->getRequestTypeStats($request,$QueryBuilder);
        else
            return $this->getList($request,$QueryBuilder);
    }
    private function getList(Request $request,Builder $QueryBuilder)
    {

        $RequestQuery = $QueryBuilder;
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.requesttype_fid',$request->get('requesttype'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.device_fid',$request->get('device'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.description_te',$request->get('descriptionte'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.priority',$request->get('priority'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.status_fid',$request->get('status'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.sender__unit_fid',$request->get('senderunit'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.current__unit_fid',$request->get('currentunit'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.adminacceptance_time',$request->get('adminacceptancetime'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.securityacceptance_time',$request->get('securityacceptancetime'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.fullsend_time',$request->get('fullsendtime'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.letternumber',$request->get('letternumber'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.letter_date',$request->get('letterdate'));
        $RequestQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestQuery,'sas_request.sender__user_fid',$request->get('senderuser'));
        $RequestsCount=$RequestQuery->select(["sas_request.*"])->count();
        if($request->get('_onlycount')!==null)
        {
            $response=['Data'=>[],'RecordCount'=>$RequestsCount];
                return response()->json($response, 200);
        }


        $Requests=SweetQueryBuilder::setPaginationIfNotNull($RequestQuery,$request->get('_startrow'),$request->get('_pagesize'))->get();
        $RequestsArray=[];
        for($i=0;$i<count($Requests);$i++)
        {
            $RequestsArray[$i]=$Requests[$i]->toArray();
            $RequesttypeField=sas_requesttype::find($Requests[$i]->requesttype_fid);
            $RequestsArray[$i]['requesttypecontent']=$RequesttypeField==null?'':$RequesttypeField->name;
            $DeviceField=sas_device::find($Requests[$i]->requesttype_fid);
            $RequestsArray[$i]['devicecontent']=$DeviceField==null?'':$DeviceField->name;
            $StatusField=sas_status::find($Requests[$i]->requesttype_fid);
            $RequestsArray[$i]['statuscontent']=$StatusField==null?'':$StatusField->name;
            $SenderunitField=sas_unit::find($Requests[$i]->sender__unit_fid);
            $RequestsArray[$i]['senderunitcontent']=$SenderunitField==null?'':$SenderunitField->name;
            $CurrentunitField=sas_unit::find($Requests[$i]->current__unit_fid);
            $RequestsArray[$i]['currentunitcontent']=$CurrentunitField==null?'':$CurrentunitField->name;
            $SenderuserField=User::find($Requests[$i]->sender__user_fid);
            $RequestsArray[$i]['senderusercontent']=$SenderuserField==null?'':$SenderuserField->name;
        }
        $Request = $this->getNormalizedList($RequestsArray);
        $response=['Data'=>$Request,'RecordCount'=>$RequestsCount,'page'=>$request->get('pg')];
            return response()->json($response, 200);
    }

    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.request.view'))
        //throw new AccessDeniedHttpException();
        $Request=sas_request::find($id);
        $RequestObjectAsArray=$Request->toArray();
        $RequesttypeID=$Request->requesttype_fid;
        $RequesttypeObject=$RequesttypeID>0?sas_requesttype::find($RequesttypeID):'';
        $RequestObjectAsArray['requesttypeinfo']=$this->getNormalizedItem($RequesttypeObject->toArray());
        $DeviceID=$Request->device_fid;
        $DeviceObject=$DeviceID>0?sas_device::find($DeviceID):'';
        $RequestObjectAsArray['deviceinfo']=$this->getNormalizedItem($DeviceObject->toArray());
        $StatusID=$Request->status_fid;
        $StatusObject=$StatusID>0?sas_status::find($StatusID):'';
        $RequestObjectAsArray['statusinfo']=$this->getNormalizedItem($StatusObject->toArray());
        $SenderunitID=$Request->sender__unit_fid;
        $SenderunitObject=$SenderunitID>0?sas_unit::find($SenderunitID):'';
        $RequestObjectAsArray['senderunitinfo']=$this->getNormalizedItem($SenderunitObject->toArray());
        $CurrentunitID=$Request->current__unit_fid;
        $CurrentunitObject=$CurrentunitID>0?sas_unit::find($CurrentunitID):'';
        $RequestObjectAsArray['currentunitinfo']=$this->getNormalizedItem($CurrentunitObject->toArray());
        $SenderuserID=$Request->sender__user_fid;
        $SenderuserObject=$SenderuserID>0?User::find($SenderuserID):'';
        $RequestObjectAsArray['senderuserinfo']=$this->getNormalizedItem($SenderuserObject->toArray());
        $Request = $this->getNormalizedItem($RequestObjectAsArray);
        return response()->json(['Data'=>$Request], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.request.delete'))
            throw new AccessDeniedHttpException();
        $Request = sas_request::find($id);
        $Request->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}