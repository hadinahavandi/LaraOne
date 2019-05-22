<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Paycenter_type=$request->input('paycenter_type');
$Planingcode=$request->input('planingcode');
$Taxtype_fid=$request->input('taxtype_fid');
$Alalhesab=$request->input('alalhesab');
$Isactive=$request->input('isactive');
$Activity = ifi_activity::create(['title'=>$Title,'paycenter_type'=>$Paycenter_type,'planingcode'=>$Planingcode,'taxtype_fid'=>$Taxtype_fid,'alalhesab'=>$Alalhesab,'isactive'=>$Isactive,'deletetime'=>-1]);
return response()->json($Activity, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Paycenter_type=$request->get('paycenter_type');
$Planingcode=$request->get('planingcode');
$Taxtype_fid=$request->get('taxtype_fid');
$Alalhesab=$request->get('alalhesab');
$Isactive=$request->get('isactive');
$Activity = new ifi_activity();
$Activity = $Activity->find($id);
$Activity->title=$Title;
$Activity->paycenter_type=$Paycenter_type;
$Activity->planingcode=$Planingcode;
$Activity->taxtype_fid=$Taxtype_fid;
$Activity->alalhesab=$Alalhesab;
$Activity->isactive=$Isactive;
$Activity->save();
return response()->json($Activity, 201);
}
public function list()
{
$Activity = ifi_activity::all();
return response()->json($Activity, 201);
}
public function get($id,Request $request)
{
$Activity = ifi_activity::find($id);
return response()->json($Activity, 201);
}
public function delete($id,Request $request)
{
$Activity = ifi_activity::find($id);
$Activity->delete();
return response()->json(['message'=>'deleted'], 201);
}
}