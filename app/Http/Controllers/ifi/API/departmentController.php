<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Region_fid=$request->input('region_fid');
$Department = ifi_department::create(['title'=>$Title,'region_fid'=>$Region_fid,'deletetime'=>-1]);
return response()->json($Department, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Region_fid=$request->get('region_fid');
$Department = new ifi_department();
$Department = $Department->find($id);
$Department->title=$Title;
$Department->region_fid=$Region_fid;
$Department->save();
return response()->json($Department, 201);
}
public function list()
{
$Department = ifi_department::all();
return response()->json($Department, 201);
}
public function get($id,Request $request)
{
$Department = ifi_department::find($id);
return response()->json($Department, 201);
}
public function delete($id,Request $request)
{
$Department = ifi_department::find($id);
$Department->delete();
return response()->json(['message'=>'deleted'], 201);
}
}