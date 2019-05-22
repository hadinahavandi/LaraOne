<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_requestunittrack;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequestunittrackController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.requestunittrack.insert'))
            throw new AccessDeniedHttpException();
    
		$InputRequest=$request->input('request');
		$InputUnit=$request->input('unit');
		$InputUser=$request->input('user');
		$Requestunittrack = sas_requestunittrack::create(['request_fid'=>$InputRequest,'unit_fid'=>$InputUnit,'user_fid'=>$InputUser,'deletetime'=>-1]);
		return response()->json(['Data'=>$Requestunittrack], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.requestunittrack.edit'))
            throw new AccessDeniedHttpException();
    
        $InputRequest=$request->get('request');
        $InputUnit=$request->get('unit');
        $InputUser=$request->get('user');
        $Requestunittrack = new sas_requestunittrack();
        $Requestunittrack = $Requestunittrack->find($id);
        $Requestunittrack->request_fid=$InputRequest;
        $Requestunittrack->unit_fid=$InputUnit;
        $Requestunittrack->user_fid=$InputUser;
        $Requestunittrack->save();
        return response()->json(['Data'=>$Requestunittrack], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.requestunittrack.insert');
        Bouncer::allow('admin')->to('sas.requestunittrack.edit');
        Bouncer::allow('admin')->to('sas.requestunittrack.list');
        Bouncer::allow('admin')->to('sas.requestunittrack.view');
        Bouncer::allow('admin')->to('sas.requestunittrack.delete');
        //if(!Bouncer::can('sas.requestunittrack.list'))
            //throw new AccessDeniedHttpException();
        $RequestunittrackQuery = sas_requestunittrack::where('id','>=','0');
        $RequestunittrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestunittrackQuery,'request_fid',$request->get('request'));
        $RequestunittrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestunittrackQuery,'unit_fid',$request->get('unit'));
        $RequestunittrackQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequestunittrackQuery,'user_fid',$request->get('user'));
        $Requestunittracks=$RequestunittrackQuery->get();
        $RequestunittracksArray=[];
        for($i=0;$i<count($Requestunittracks);$i++)
        {
            $RequestunittracksArray[$i]=$Requestunittracks[$i]->toArray();
            $RequestField=$Requestunittracks[$i]->request();
            $RequestunittracksArray[$i]['requestcontent']=$RequestField==null?'':$RequestField->name;
            $UnitField=$Requestunittracks[$i]->unit();
            $RequestunittracksArray[$i]['unitcontent']=$UnitField==null?'':$UnitField->name;
            $UserField=$Requestunittracks[$i]->user();
            $RequestunittracksArray[$i]['usercontent']=$UserField==null?'':$UserField->name;
        }
        $Requestunittrack = $this->getNormalizedList($RequestunittracksArray);
        return response()->json(['Data'=>$Requestunittrack,'RecordCount'=>count($Requestunittrack)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.requestunittrack.view'))
            //throw new AccessDeniedHttpException();
        $Requestunittrack = $this->getNormalizedItem(sas_requestunittrack::find($id)->toArray());
        return response()->json(['Data'=>$Requestunittrack], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.requestunittrack.delete'))
            throw new AccessDeniedHttpException();
        $Requestunittrack = sas_requestunittrack::find($id);
        $Requestunittrack->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}