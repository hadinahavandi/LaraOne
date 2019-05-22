<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Role = ifi_role::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Role, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Role = new ifi_role();
$Role = $Role->find($id);
$Role->title=$Title;
$Role->save();
return response()->json($Role, 201);
}
public function list()
{
$Role = ifi_role::all();
return response()->json($Role, 201);
}
public function get($id,Request $request)
{
$Role = ifi_role::find($id);
return response()->json($Role, 201);
}
public function delete($id,Request $request)
{
$Role = ifi_role::find($id);
$Role->delete();
return response()->json(['message'=>'deleted'], 201);
}
}