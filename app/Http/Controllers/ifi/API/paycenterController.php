<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_paycenter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaycenterController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Chapter=$request->input('chapter');
$Accountingcode=$request->input('accountingcode');
$Paycenter_fid=$request->input('paycenter_fid');
$Paycenter = ifi_paycenter::create(['title'=>$Title,'chapter'=>$Chapter,'accountingcode'=>$Accountingcode,'paycenter_fid'=>$Paycenter_fid,'deletetime'=>-1]);
return response()->json($Paycenter, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Chapter=$request->get('chapter');
$Accountingcode=$request->get('accountingcode');
$Paycenter_fid=$request->get('paycenter_fid');
$Paycenter = new ifi_paycenter();
$Paycenter = $Paycenter->find($id);
$Paycenter->title=$Title;
$Paycenter->chapter=$Chapter;
$Paycenter->accountingcode=$Accountingcode;
$Paycenter->paycenter_fid=$Paycenter_fid;
$Paycenter->save();
return response()->json($Paycenter, 201);
}
public function list()
{
$Paycenter = ifi_paycenter::all();
return response()->json($Paycenter, 201);
}
public function get($id,Request $request)
{
$Paycenter = ifi_paycenter::find($id);
return response()->json($Paycenter, 201);
}
public function delete($id,Request $request)
{
$Paycenter = ifi_paycenter::find($id);
$Paycenter->delete();
return response()->json(['message'=>'deleted'], 201);
}
}