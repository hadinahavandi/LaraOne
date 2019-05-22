<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_devicetype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DevicetypeController extends SweetController
{

    public function add(Request $request)
    {
        if(!Bouncer::can('sas.devicetype.insert'))
            throw new AccessDeniedHttpException();

        $InputName=$request->input('name');
        $InputDevicetype=$request->input('devicetype');
        $InputNeedssecurityacceptance=$request->input('needssecurityacceptance');
        $Devicetype = sas_devicetype::create(['name'=>$InputName,'devicetype_fid'=>$InputDevicetype,'is_needssecurityacceptance'=>$InputNeedssecurityacceptance,'deletetime'=>-1]);
        return response()->json(['Data'=>$Devicetype], 201);
    }
    public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.devicetype.edit'))
            throw new AccessDeniedHttpException();

        $InputName=$request->get('name');
        $InputDevicetype=$request->get('devicetype');
        $InputNeedssecurityacceptance=$request->get('needssecurityacceptance');
        $Devicetype = new sas_devicetype();
        $Devicetype = $Devicetype->find($id);
        $Devicetype->name=$InputName;
        $Devicetype->devicetype_fid=$InputDevicetype;
        $Devicetype->is_needssecurityacceptance=$InputNeedssecurityacceptance;
        $Devicetype->save();
        return response()->json(['Data'=>$Devicetype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.devicetype.insert');
        Bouncer::allow('admin')->to('sas.devicetype.edit');
        Bouncer::allow('admin')->to('sas.devicetype.list');
        Bouncer::allow('admin')->to('sas.devicetype.view');
        Bouncer::allow('admin')->to('sas.devicetype.delete');
        //if(!Bouncer::can('sas.devicetype.list'))
        //throw new AccessDeniedHttpException();
        $DevicetypeQuery = sas_devicetype::where('id','>=','0');
        $DevicetypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($DevicetypeQuery,'name',$request->get('name'));
        $DevicetypeQuery =SweetQueryBuilder::OrderIfNotNull($DevicetypeQuery,'name__sort','name',$request->get('name__sort'));
        $DevicetypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($DevicetypeQuery,'devicetype_fid',$request->get('devicetype'));
        $DevicetypeQuery =SweetQueryBuilder::OrderIfNotNull($DevicetypeQuery,'devicetype__sort','devicetype_fid',$request->get('devicetype__sort'));
        $DevicetypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($DevicetypeQuery,'is_needssecurityacceptance',$request->get('needssecurityacceptance'));
        $DevicetypeQuery =SweetQueryBuilder::OrderIfNotNull($DevicetypeQuery,'needssecurityacceptance__sort','is_needssecurityacceptance',$request->get('needssecurityacceptance__sort'));
        $DevicetypesCount=$DevicetypeQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$DevicetypesCount], 200);
        $Devicetypes=SweetQueryBuilder::setPaginationIfNotNull($DevicetypeQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $DevicetypesArray=[];
        for($i=0;$i<count($Devicetypes);$i++)
        {
            $DevicetypesArray[$i]=$Devicetypes[$i]->toArray();
            $DevicetypeField=$Devicetypes[$i]->devicetype();
            $DevicetypesArray[$i]['devicetypecontent']=$DevicetypeField==null?'':$DevicetypeField->name;
        }
        $Devicetype = $this->getNormalizedList($DevicetypesArray);
        return response()->json(['Data'=>$Devicetype,'RecordCount'=>$DevicetypesCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.devicetype.view'))
        //throw new AccessDeniedHttpException();
        $Devicetype=sas_devicetype::find($id);
        $DevicetypeObjectAsArray=$Devicetype->toArray();
        $DevicetypeID=$Devicetype->devicetype_fid;
        $DevicetypeObject=$DevicetypeID>0?sas_devicetype::find($DevicetypeID):'';
        $DevicetypeObjectAsArray['devicetypeinfo']=$this->getNormalizedItem($DevicetypeObject->toArray());
        $Devicetype = $this->getNormalizedItem($DevicetypeObjectAsArray);
        return response()->json(['Data'=>$Devicetype], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.devicetype.delete'))
            throw new AccessDeniedHttpException();
        $Devicetype = sas_devicetype::find($id);
        $Devicetype->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}