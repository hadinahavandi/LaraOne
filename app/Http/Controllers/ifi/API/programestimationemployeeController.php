<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_programestimationemployee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramestimationemployeeController extends Controller
{

public function add(Request $request)
    {
    
$Employee_fid=$request->input('employee_fid');
$Activity_fid=$request->input('activity_fid');
$Programestimation_fid=$request->input('programestimation_fid');
$Employmenttype_fid=$request->input('employmenttype_fid');
$Totalwork=$request->input('totalwork');
$Workunit_fid=$request->input('workunit_fid');
$Programestimationemployee = ifi_programestimationemployee::create(['employee_fid'=>$Employee_fid,'activity_fid'=>$Activity_fid,'programestimation_fid'=>$Programestimation_fid,'employmenttype_fid'=>$Employmenttype_fid,'totalwork'=>$Totalwork,'workunit_fid'=>$Workunit_fid,'deletetime'=>-1]);
return response()->json($Programestimationemployee, 201);
}
public function update($id,Request $request)
    {
    
$Employee_fid=$request->get('employee_fid');
$Activity_fid=$request->get('activity_fid');
$Programestimation_fid=$request->get('programestimation_fid');
$Employmenttype_fid=$request->get('employmenttype_fid');
$Totalwork=$request->get('totalwork');
$Workunit_fid=$request->get('workunit_fid');
$Programestimationemployee = new ifi_programestimationemployee();
$Programestimationemployee = $Programestimationemployee->find($id);
$Programestimationemployee->employee_fid=$Employee_fid;
$Programestimationemployee->activity_fid=$Activity_fid;
$Programestimationemployee->programestimation_fid=$Programestimation_fid;
$Programestimationemployee->employmenttype_fid=$Employmenttype_fid;
$Programestimationemployee->totalwork=$Totalwork;
$Programestimationemployee->workunit_fid=$Workunit_fid;
$Programestimationemployee->save();
return response()->json($Programestimationemployee, 201);
}
public function list()
{
$Programestimationemployee = ifi_programestimationemployee::all();
return response()->json($Programestimationemployee, 201);
}
public function get($id,Request $request)
{
$Programestimationemployee = ifi_programestimationemployee::find($id);
return response()->json($Programestimationemployee, 201);
}
public function delete($id,Request $request)
{
$Programestimationemployee = ifi_programestimationemployee::find($id);
$Programestimationemployee->delete();
return response()->json(['message'=>'deleted'], 201);
}
}