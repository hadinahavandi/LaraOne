<?php
namespace App\Http\Controllers\itsap\API;
use App\models\itsap\itsap_servicetypegroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicetypegroupController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Servicetypegroup_fid=$request->input('servicetypegroup_fid');
$Servicetypegroup = itsap_servicetypegroup::create(['title'=>$Title,'servicetypegroup_fid'=>$Servicetypegroup_fid,'deletetime'=>-1]);
return response()->json($Servicetypegroup, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Servicetypegroup_fid=$request->get('servicetypegroup_fid');
$Servicetypegroup = new itsap_servicetypegroup();
$Servicetypegroup = $Servicetypegroup->find($id);
$Servicetypegroup->title=$Title;
$Servicetypegroup->servicetypegroup_fid=$Servicetypegroup_fid;
$Servicetypegroup->save();
return response()->json($Servicetypegroup, 201);
}
public function list()
{
$Servicetypegroup = itsap_servicetypegroup::all();
return response()->json($Servicetypegroup, 201);
}
public function get($id,Request $request)
{
$Servicetypegroup = itsap_servicetypegroup::find($id);
return response()->json($Servicetypegroup, 201);
}
public function delete($id,Request $request)
{
$Servicetypegroup = itsap_servicetypegroup::find($id);
$Servicetypegroup->delete();
return response()->json(['message'=>'deleted'], 201);
}
}