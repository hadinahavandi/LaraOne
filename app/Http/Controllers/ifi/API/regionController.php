<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Region = ifi_region::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Region, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Region = new ifi_region();
$Region = $Region->find($id);
$Region->title=$Title;
$Region->save();
return response()->json($Region, 201);
}
public function list()
{
$Region = ifi_region::all();
return response()->json($Region, 201);
}
public function get($id,Request $request)
{
$Region = ifi_region::find($id);
return response()->json($Region, 201);
}
public function delete($id,Request $request)
{
$Region = ifi_region::find($id);
$Region->delete();
return response()->json(['message'=>'deleted'], 201);
}
}