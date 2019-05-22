<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_unittype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnittypeController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.unittype.insert'))
            throw new AccessDeniedHttpException();
    
		$InputName=$request->input('name');
		$Unittype = sas_unittype::create(['name'=>$InputName,'deletetime'=>-1]);
		return response()->json(['Data'=>$Unittype], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.unittype.edit'))
            throw new AccessDeniedHttpException();
    
        $InputName=$request->get('name');
        $Unittype = new sas_unittype();
        $Unittype = $Unittype->find($id);
        $Unittype->name=$InputName;
        $Unittype->save();
        return response()->json(['Data'=>$Unittype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.unittype.insert');
        Bouncer::allow('admin')->to('sas.unittype.edit');
        Bouncer::allow('admin')->to('sas.unittype.list');
        Bouncer::allow('admin')->to('sas.unittype.view');
        Bouncer::allow('admin')->to('sas.unittype.delete');
        //if(!Bouncer::can('sas.unittype.list'))
            //throw new AccessDeniedHttpException();
        $UnittypeQuery = sas_unittype::where('id','>=','0');
        $UnittypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnittypeQuery,'name',$request->get('name'));
        $Unittypes=$UnittypeQuery->get();
        $UnittypesArray=[];
        for($i=0;$i<count($Unittypes);$i++)
        {
            $UnittypesArray[$i]=$Unittypes[$i]->toArray();
        }
        $Unittype = $this->getNormalizedList($UnittypesArray);
        return response()->json(['Data'=>$Unittype,'RecordCount'=>count($Unittype)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.unittype.view'))
            //throw new AccessDeniedHttpException();
        $Unittype=sas_unittype::find($id);
        $UnittypeObjectAsArray=$Unittype->toArray();
        $Unittype = $this->getNormalizedItem($UnittypeObjectAsArray);
        return response()->json(['Data'=>$Unittype], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.unittype.delete'))
            throw new AccessDeniedHttpException();
        $Unittype = sas_unittype::find($id);
        $Unittype->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}