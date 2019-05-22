<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_requestmessage;
use App\Http\Controllers\Controller;
use App\models\sas\sas_unit;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequestmessageController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.requestmessage.insert'))
            throw new AccessDeniedHttpException();
    
		$InputMessagete=$request->input('messagete');
		$InputRequest=$request->input('request');
		$InputUnit=$request->input('unit');
		$InputUser=$request->input('user');
		$Requestmessage = sas_requestmessage::create(['message_te'=>$InputMessagete,'request_fid'=>$InputRequest,'unit_fid'=>$InputUnit,'user_fid'=>$InputUser,'deletetime'=>-1]);
		return response()->json(['Data'=>$Requestmessage], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.requestmessage.edit'))
            throw new AccessDeniedHttpException();
    
        $InputMessagete=$request->get('messagete');
        $InputRequest=$request->get('request');
        $InputUnit=$request->get('unit');
        $InputUser=$request->get('user');
        $Requestmessage = new sas_requestmessage();
        $Requestmessage = $Requestmessage->find($id);
        $Requestmessage->message_te=$InputMessagete;
        $Requestmessage->request_fid=$InputRequest;
        $Requestmessage->unit_fid=$InputUnit;
        $Requestmessage->user_fid=$InputUser;
        $Requestmessage->save();
        return response()->json(['Data'=>$Requestmessage], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.requestmessage.insert');
        Bouncer::allow('admin')->to('sas.requestmessage.edit');
        Bouncer::allow('admin')->to('sas.requestmessage.list');
        Bouncer::allow('admin')->to('sas.requestmessage.view');
        Bouncer::allow('admin')->to('sas.requestmessage.delete');
        //if(!Bouncer::can('sas.requestmessage.list'))
            //throw new AccessDeniedHttpException();
        $RequestmessageQuery = sas_requestmessage::where('id','>=','0');
        $RequestmessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestmessageQuery,'message_te',$request->get('messagete'));
        $RequestmessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestmessageQuery,'request_fid',$request->get('request'));
        $RequestmessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestmessageQuery,'unit_fid',$request->get('unit'));
        $RequestmessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestmessageQuery,'user_fid',$request->get('user'));
        $Requestmessages=$RequestmessageQuery->get();
        $RequestmessagesArray=[];
        for($i=0;$i<count($Requestmessages);$i++)
        {
            $RequestmessagesArray[$i]=$Requestmessages[$i]->toArray();
            $RequestField=$Requestmessages[$i]->request();
            $RequestmessagesArray[$i]['requestcontent']=$RequestField==null?'':$RequestField->name;
            $UnitField=$Requestmessages[$i]->unit();
            $RequestmessagesArray[$i]['unitcontent']=$UnitField==null?'':$UnitField->name;
            $UserField=$Requestmessages[$i]->user();
            $RequestmessagesArray[$i]['usercontent']=$UserField==null?'':$UserField->name;
        }
        $Requestmessage = $this->getNormalizedList($RequestmessagesArray);
        return response()->json(['Data'=>$Requestmessage,'RecordCount'=>count($Requestmessage)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.requestmessage.view'))
            //throw new AccessDeniedHttpException();
        $Requestmessage = $this->getNormalizedItem(sas_requestmessage::find($id)->toArray());
        return response()->json(['Data'=>$Requestmessage], 200);
    }
    public function getbyrequest($id,Request $request)
    {
        //if(!Bouncer::can('sas.requestmessage.view'))
            //throw new AccessDeniedHttpException();
        $Requests=sas_requestmessage::where('request_fid','=',$id)->get();
        $RequestsArray=$Requests->toArray();
        for($i=0;$i<count($Requests);$i++)
            $RequestsArray[$i]['unitinfo']=sas_unit::find($Requests[$i]->unit_fid);
        $Requestmessage = $this->getNormalizedList($RequestsArray);
        return response()->json(['Data'=>$Requestmessage], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.requestmessage.delete'))
            throw new AccessDeniedHttpException();
        $Requestmessage = sas_requestmessage::find($id);
        $Requestmessage->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}