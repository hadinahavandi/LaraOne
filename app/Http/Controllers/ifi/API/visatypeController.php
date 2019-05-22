<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_visatype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisatypeController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Visatype = ifi_visatype::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Visatype, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Visatype = new ifi_visatype();
$Visatype = $Visatype->find($id);
$Visatype->title=$Title;
$Visatype->save();
return response()->json($Visatype, 201);
}
public function list()
{
$Visatype = ifi_visatype::all();
return response()->json($Visatype, 201);
}
public function get($id,Request $request)
{
$Visatype = ifi_visatype::find($id);
return response()->json($Visatype, 201);
}
public function delete($id,Request $request)
{
$Visatype = ifi_visatype::find($id);
$Visatype->delete();
return response()->json(['message'=>'deleted'], 201);
}
}