<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_taxtype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaxtypeController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Taxtype = ifi_taxtype::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Taxtype, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Taxtype = new ifi_taxtype();
$Taxtype = $Taxtype->find($id);
$Taxtype->title=$Title;
$Taxtype->save();
return response()->json($Taxtype, 201);
}
public function list()
{
$Taxtype = ifi_taxtype::all();
return response()->json($Taxtype, 201);
}
public function get($id,Request $request)
{
$Taxtype = ifi_taxtype::find($id);
return response()->json($Taxtype, 201);
}
public function delete($id,Request $request)
{
$Taxtype = ifi_taxtype::find($id);
$Taxtype->delete();
return response()->json(['message'=>'deleted'], 201);
}
}