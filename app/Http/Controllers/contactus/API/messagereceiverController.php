<?php
namespace App\Http\Controllers\contactus\API;
use App\models\contactus\contactus_messagereceiver;
use App\Http\Controllers\Controller;
use App\Sweet\SweetController;
use Illuminate\Http\Request;

class MessagereceiverController extends SweetController
{

public function add(Request $request)
    {
    
$Name=$request->input('name');
$Userid=$request->input('userid');
$Messagereceiver = contactus_messagereceiver::create(['name'=>$Name,'user_id'=>$Userid,'deletetime'=>-1]);
return response()->json($Messagereceiver, 201);
}
public function update($id,Request $request)
    {
    
$Name=$request->get('name');
$Userid=$request->get('userid');
$Messagereceiver = new contactus_messagereceiver();
$Messagereceiver = $Messagereceiver->find($id);
$Messagereceiver->name=$Name;
$Messagereceiver->user_id=$Userid;
$Messagereceiver->save();
return response()->json($Messagereceiver, 202);
}
public function list()
{
$Messagereceiver = $this->getNormalizedList(contactus_messagereceiver::all()->toArray());
return response()->json(['Data'=>$Messagereceiver,'RecordCount'=>count($Messagereceiver)], 200);
}
public function get($id,Request $request)
{
$Messagereceiver = $this->getNormalizedItem(contactus_messagereceiver::find($id)->toArray());
return response()->json(['Data'=>$Messagereceiver], 200);
}
public function delete($id,Request $request)
{
$Messagereceiver = contactus_messagereceiver::find($id);
$Messagereceiver->delete();
return response()->json(['message'=>'deleted'], 202);
}
}