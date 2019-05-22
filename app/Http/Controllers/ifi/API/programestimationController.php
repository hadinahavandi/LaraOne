<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_programestimation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramestimationController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Department_fid=$request->input('department_fid');
$Class_fid=$request->input('class_fid');
$Programmaketype_fid=$request->input('programmaketype_fid');
$Totalprogramcount=$request->input('totalprogramcount');
$Timeperprogram=$request->input('timeperprogram');
$Is_haslegalproblem=$request->input('is_haslegalproblem');
$Approval_date=$request->input('approval_date');
$End_date=$request->input('end_date');
$Add_date=$request->input('add_date');
$Producer_employee_fid=$request->input('producer_employee_fid');
$Executor_employee_fid=$request->input('executor_employee_fid');
$Paycenter_fid=$request->input('paycenter_fid');
$Makergroup_paycenter_fid=$request->input('makergroup_paycenter_fid');
$Programestimation = ifi_programestimation::create(['title'=>$Title,'department_fid'=>$Department_fid,'class_fid'=>$Class_fid,'programmaketype_fid'=>$Programmaketype_fid,'totalprogramcount'=>$Totalprogramcount,'timeperprogram'=>$Timeperprogram,'is_haslegalproblem'=>$Is_haslegalproblem,'approval_date'=>$Approval_date,'end_date'=>$End_date,'add_date'=>$Add_date,'producer_employee_fid'=>$Producer_employee_fid,'executor_employee_fid'=>$Executor_employee_fid,'paycenter_fid'=>$Paycenter_fid,'makergroup_paycenter_fid'=>$Makergroup_paycenter_fid,'deletetime'=>-1]);
return response()->json($Programestimation, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Department_fid=$request->get('department_fid');
$Class_fid=$request->get('class_fid');
$Programmaketype_fid=$request->get('programmaketype_fid');
$Totalprogramcount=$request->get('totalprogramcount');
$Timeperprogram=$request->get('timeperprogram');
$Is_haslegalproblem=$request->get('is_haslegalproblem');
$Approval_date=$request->get('approval_date');
$End_date=$request->get('end_date');
$Add_date=$request->get('add_date');
$Producer_employee_fid=$request->get('producer_employee_fid');
$Executor_employee_fid=$request->get('executor_employee_fid');
$Paycenter_fid=$request->get('paycenter_fid');
$Makergroup_paycenter_fid=$request->get('makergroup_paycenter_fid');
$Programestimation = new ifi_programestimation();
$Programestimation = $Programestimation->find($id);
$Programestimation->title=$Title;
$Programestimation->department_fid=$Department_fid;
$Programestimation->class_fid=$Class_fid;
$Programestimation->programmaketype_fid=$Programmaketype_fid;
$Programestimation->totalprogramcount=$Totalprogramcount;
$Programestimation->timeperprogram=$Timeperprogram;
$Programestimation->is_haslegalproblem=$Is_haslegalproblem;
$Programestimation->approval_date=$Approval_date;
$Programestimation->end_date=$End_date;
$Programestimation->add_date=$Add_date;
$Programestimation->producer_employee_fid=$Producer_employee_fid;
$Programestimation->executor_employee_fid=$Executor_employee_fid;
$Programestimation->paycenter_fid=$Paycenter_fid;
$Programestimation->makergroup_paycenter_fid=$Makergroup_paycenter_fid;
$Programestimation->save();
return response()->json($Programestimation, 201);
}
public function list()
{
$Programestimation = ifi_programestimation::all();
return response()->json($Programestimation, 201);
}
public function get($id,Request $request)
{
$Programestimation = ifi_programestimation::find($id);
return response()->json($Programestimation, 201);
}
public function delete($id,Request $request)
{
$Programestimation = ifi_programestimation::find($id);
$Programestimation->delete();
return response()->json(['message'=>'deleted'], 201);
}
}