<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_requesttype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequesttypeController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.requesttype.insert'))
            throw new AccessDeniedHttpException();
    
		$InputName=$request->input('name');
		$InputPriority=$request->input('priority');
		$InputNeedssecurityacceptance=$request->input('needssecurityacceptance');
		$InputMotherrequesttype=$request->input('motherrequesttype');
		$InputHardwareneeded=$request->input('hardwareneeded');
		$Requesttype = sas_requesttype::create(['name'=>$InputName,'priority'=>$InputPriority,'is_needssecurityacceptance'=>$InputNeedssecurityacceptance,'mother__requesttype_fid'=>$InputMotherrequesttype,'is_hardwareneeded'=>$InputHardwareneeded,'deletetime'=>-1]);
		return response()->json(['Data'=>$Requesttype], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.requesttype.edit'))
            throw new AccessDeniedHttpException();
    
        $InputName=$request->get('name');
        $InputPriority=$request->get('priority');
        $InputNeedssecurityacceptance=$request->get('needssecurityacceptance');
        $InputMotherrequesttype=$request->get('motherrequesttype');
        $InputHardwareneeded=$request->get('hardwareneeded');
        $Requesttype = new sas_requesttype();
        $Requesttype = $Requesttype->find($id);
        $Requesttype->name=$InputName;
        $Requesttype->priority=$InputPriority;
        $Requesttype->is_needssecurityacceptance=$InputNeedssecurityacceptance;
        $Requesttype->mother__requesttype_fid=$InputMotherrequesttype;
        $Requesttype->is_hardwareneeded=$InputHardwareneeded;
        $Requesttype->save();
        return response()->json(['Data'=>$Requesttype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.requesttype.insert');
        Bouncer::allow('admin')->to('sas.requesttype.edit');
        Bouncer::allow('admin')->to('sas.requesttype.list');
        Bouncer::allow('admin')->to('sas.requesttype.view');
        Bouncer::allow('admin')->to('sas.requesttype.delete');
        //if(!Bouncer::can('sas.requesttype.list'))
            //throw new AccessDeniedHttpException();
        $RequesttypeQuery = sas_requesttype::where('id','>=','0');
        $RequesttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequesttypeQuery,'name',$request->get('name'));
        $RequesttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequesttypeQuery,'priority',$request->get('priority'));
        $RequesttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequesttypeQuery,'is_needssecurityacceptance',$request->get('needssecurityacceptance'));
        $RequesttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequesttypeQuery,'mother__requesttype_fid',$request->get('motherrequesttype'));
        $RequesttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($RequesttypeQuery,'is_hardwareneeded',$request->get('hardwareneeded'));
        $Requesttypes=$RequesttypeQuery->get();
        $RequesttypesArray=[];
        for($i=0;$i<count($Requesttypes);$i++)
        {
            $RequesttypesArray[$i]=$Requesttypes[$i]->toArray();
            $MotherrequesttypeField=$Requesttypes[$i]->motherrequesttype();
            $RequesttypesArray[$i]['motherrequesttypecontent']=$MotherrequesttypeField==null?'':$MotherrequesttypeField->name;
        }
        $Requesttype = $this->getNormalizedList($RequesttypesArray);
        return response()->json(['Data'=>$Requesttype,'RecordCount'=>count($Requesttype)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.requesttype.view'))
            //throw new AccessDeniedHttpException();
        $Requesttype = $this->getNormalizedItem(sas_requesttype::find($id)->toArray());
        return response()->json(['Data'=>$Requesttype], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.requesttype.delete'))
            throw new AccessDeniedHttpException();
        $Requesttype = sas_requesttype::find($id);
        $Requesttype->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}