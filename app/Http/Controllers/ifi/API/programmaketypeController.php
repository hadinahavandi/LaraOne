<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_programmaketype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgrammaketypeController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Programmaketype = ifi_programmaketype::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Programmaketype, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Programmaketype = new ifi_programmaketype();
$Programmaketype = $Programmaketype->find($id);
$Programmaketype->title=$Title;
$Programmaketype->save();
return response()->json($Programmaketype, 201);
}
public function list()
{
$Programmaketype = ifi_programmaketype::all();
return response()->json($Programmaketype, 201);
}
public function get($id,Request $request)
{
$Programmaketype = ifi_programmaketype::find($id);
return response()->json($Programmaketype, 201);
}
public function delete($id,Request $request)
{
$Programmaketype = ifi_programmaketype::find($id);
$Programmaketype->delete();
return response()->json(['message'=>'deleted'], 201);
}
}