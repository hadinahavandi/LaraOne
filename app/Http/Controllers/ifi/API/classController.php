<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_class;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Class = ifi_class::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Class, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Class = new ifi_class();
$Class = $Class->find($id);
$Class->title=$Title;
$Class->save();
return response()->json($Class, 201);
}
public function list()
{
$Class = ifi_class::all();
return response()->json($Class, 201);
}
public function get($id,Request $request)
{
$Class = ifi_class::find($id);
return response()->json($Class, 201);
}
public function delete($id,Request $request)
{
$Class = ifi_class::find($id);
$Class->delete();
return response()->json(['message'=>'deleted'], 201);
}
}