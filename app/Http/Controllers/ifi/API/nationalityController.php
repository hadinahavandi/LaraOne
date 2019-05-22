<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_nationality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NationalityController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Flag_flu=$request->input('flag_flu');
$Nationality = ifi_nationality::create(['title'=>$Title,'flag_flu'=>$Flag_flu,'deletetime'=>-1]);
return response()->json($Nationality, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Flag_flu=$request->get('flag_flu');
$Nationality = new ifi_nationality();
$Nationality = $Nationality->find($id);
$Nationality->title=$Title;
$Nationality->flag_flu=$Flag_flu;
$Nationality->save();
return response()->json($Nationality, 201);
}
public function list()
{
$Nationality = ifi_nationality::all();
return response()->json($Nationality, 201);
}
public function get($id,Request $request)
{
$Nationality = ifi_nationality::find($id);
return response()->json($Nationality, 201);
}
public function delete($id,Request $request)
{
$Nationality = ifi_nationality::find($id);
$Nationality->delete();
return response()->json(['message'=>'deleted'], 201);
}
}