<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_requeststatustrack;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequeststatustrackController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.requeststatustrack.insert'))
            throw new AccessDeniedHttpException();
    
		$InputStatus=$request->input('status');
		$InputRequest=$request->input('request');
		$InputUser=$request->input('user');
		$Requeststatustrack = sas_requeststatustrack::create(['status_fid'=>$InputStatus,'request_fid'=>$InputRequest,'user_fid'=>$InputUser,'deletetime'=>-1]);
		return response()->json(['Data'=>$Requeststatustrack], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.requeststatustrack.edit'))
            throw new AccessDeniedHttpException();
    
        $InputStatus=$request->get('status');
        $InputRequest=$request->get('request');
        $InputUser=$request->get('user');
        $Requeststatustrack = new sas_requeststatustrack();
        $Requeststatustrack = $Requeststatustrack->find($id);
        $Requeststatustrack->status_fid=$InputStatus;
        $Requeststatustrack->request_fid=$InputRequest;
        $Requeststatustrack->user_fid=$InputUser;
        $Requeststatustrack->save();
        return response()->json(['Data'=>$Requeststatustrack], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.requeststatustrack.insert');
        Bouncer::allow('admin')->to('sas.requeststatustrack.edit');
        Bouncer::allow('admin')->to('sas.requeststatustrack.list');
        Bouncer::allow('admin')->to('sas.requeststatustrack.view');
        Bouncer::allow('admin')->to('sas.requeststatustrack.delete');
        //if(!Bouncer::can('sas.requeststatustrack.list'))
            //throw new AccessDeniedHttpException();
        $RequeststatustrackQuery = sas_requeststatustrack::where('id','>=','0');
        $RequeststatustrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequeststatustrackQuery,'status_fid',$request->get('status'));
        $RequeststatustrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequeststatustrackQuery,'request_fid',$request->get('request'));
        $RequeststatustrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequeststatustrackQuery,'user_fid',$request->get('user'));
        $Requeststatustracks=$RequeststatustrackQuery->get();
        $RequeststatustracksArray=[];
        for($i=0;$i<count($Requeststatustracks);$i++)
        {
            $RequeststatustracksArray[$i]=$Requeststatustracks[$i]->toArray();
            $StatusField=$Requeststatustracks[$i]->status();
            $RequeststatustracksArray[$i]['statuscontent']=$StatusField==null?'':$StatusField->name;
            $RequestField=$Requeststatustracks[$i]->request();
            $RequeststatustracksArray[$i]['requestcontent']=$RequestField==null?'':$RequestField->name;
            $UserField=$Requeststatustracks[$i]->user();
            $RequeststatustracksArray[$i]['usercontent']=$UserField==null?'':$UserField->name;
        }
        $Requeststatustrack = $this->getNormalizedList($RequeststatustracksArray);
        return response()->json(['Data'=>$Requeststatustrack,'RecordCount'=>count($Requeststatustrack)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.requeststatustrack.view'))
            //throw new AccessDeniedHttpException();
        $Requeststatustrack = $this->getNormalizedItem(sas_requeststatustrack::find($id)->toArray());
        return response()->json(['Data'=>$Requeststatustrack], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.requeststatustrack.delete'))
            throw new AccessDeniedHttpException();
        $Requeststatustrack = sas_requeststatustrack::find($id);
        $Requeststatustrack->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}