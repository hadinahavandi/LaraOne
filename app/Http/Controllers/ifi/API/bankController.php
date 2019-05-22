<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Bank = ifi_bank::create(['title'=>$Title,'deletetime'=>-1]);
return response()->json($Bank, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Bank = new ifi_bank();
$Bank = $Bank->find($id);
$Bank->title=$Title;
$Bank->save();
return response()->json($Bank, 201);
}
public function list()
{
$Bank = ifi_bank::all();
return response()->json($Bank, 201);
}
public function get($id,Request $request)
{
$Bank = ifi_bank::find($id);
return response()->json($Bank, 201);
}
public function delete($id,Request $request)
{
$Bank = ifi_bank::find($id);
$Bank->delete();
return response()->json(['message'=>'deleted'], 201);
}
}