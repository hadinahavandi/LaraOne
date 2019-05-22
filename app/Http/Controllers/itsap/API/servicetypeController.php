<?php
namespace App\Http\Controllers\itsap\API;
use App\models\itsap\itsap_servicetype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicetypeController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Priority=$request->input('priority');
$Servicetypegroup_fid=$request->input('servicetypegroup_fid');
$Is_needdevice=$request->input('is_needdevice');
$Servicetype = itsap_servicetype::create(['title'=>$Title,'priority'=>$Priority,'servicetypegroup_fid'=>$Servicetypegroup_fid,'is_needdevice'=>$Is_needdevice,'deletetime'=>-1]);
return response()->json($Servicetype, 201);
}
public function update($id,Request $request)
    {

$Title=$request->get('title');
$Priority=$request->get('priority');
$Servicetypegroup_fid=$request->get('servicetypegroup_fid');
$Is_needdevice=$request->get('is_needdevice');
$Servicetype = new itsap_servicetype();
$Servicetype = $Servicetype->find($id);
$Servicetype->title=$Title;
$Servicetype->priority=$Priority;
$Servicetype->servicetypegroup_fid=$Servicetypegroup_fid;
$Servicetype->is_needdevice=$Is_needdevice;
$Servicetype->save();
return response()->json($Servicetype, 201);
}
public function list()
{
$Servicetype = itsap_servicetype::all();
return response()->json($Servicetype, 201);
}
public function get($id,Request $request)
{
$Servicetype = itsap_servicetype::find($id);
return response()->json($Servicetype, 201);
}
public function delete($id,Request $request)
{
$Servicetype = itsap_servicetype::find($id);
$Servicetype->delete();
return response()->json(['message'=>'deleted'], 201);
}
}