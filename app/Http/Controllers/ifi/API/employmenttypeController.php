<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_employmenttype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmploymenttypeController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Taxfactor=$request->input('taxfactor');
$Employmenttype = ifi_employmenttype::create(['title'=>$Title,'taxfactor'=>$Taxfactor,'deletetime'=>-1]);
return response()->json($Employmenttype, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Taxfactor=$request->get('taxfactor');
$Employmenttype = new ifi_employmenttype();
$Employmenttype = $Employmenttype->find($id);
$Employmenttype->title=$Title;
$Employmenttype->taxfactor=$Taxfactor;
$Employmenttype->save();
return response()->json($Employmenttype, 201);
}
public function list()
{
$Employmenttype = ifi_employmenttype::all();
return response()->json($Employmenttype, 201);
}
public function get($id,Request $request)
{
$Employmenttype = ifi_employmenttype::find($id);
return response()->json($Employmenttype, 201);
}
public function delete($id,Request $request)
{
$Employmenttype = ifi_employmenttype::find($id);
$Employmenttype->delete();
return response()->json(['message'=>'deleted'], 201);
}
}