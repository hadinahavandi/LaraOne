<?php
namespace App\Http\Controllers\itsap\API;
use App\models\itsap\itsap_servicerequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicerequestController extends Controller
{

public function add(Request $request)
    {
    
$Title=$request->input('title');
$Role_systemuser_fid=$request->input('role_systemuser_fid');
$Unit_fid=$request->input('unit_fid');
$Servicetype_fid=$request->input('servicetype_fid');
$Description=$request->input('description');
$Priority=$request->input('priority');
$File1_flu=$request->input('file1_flu');
$Request_date=$request->input('request_date');
$Letterfile_flu=$request->input('letterfile_flu');
$Securityacceptor_role_systemuser_fid=$request->input('securityacceptor_role_systemuser_fid');
$Is_securityaccepted=$request->input('is_securityaccepted');
$Securityacceptancemessage=$request->input('securityacceptancemessage');
$Securityacceptance_date=$request->input('securityacceptance_date');
$Letternumber=$request->input('letternumber');
$Letter_date=$request->input('letter_date');
$Last_servicestatus_fid=$request->input('last_servicestatus_fid');
$Servicerequest = itsap_servicerequest::create(['title'=>$Title,'role_systemuser_fid'=>$Role_systemuser_fid,'unit_fid'=>$Unit_fid,'servicetype_fid'=>$Servicetype_fid,'description'=>$Description,'priority'=>$Priority,'file1_flu'=>$File1_flu,'request_date'=>$Request_date,'letterfile_flu'=>$Letterfile_flu,'securityacceptor_role_systemuser_fid'=>$Securityacceptor_role_systemuser_fid,'is_securityaccepted'=>$Is_securityaccepted,'securityacceptancemessage'=>$Securityacceptancemessage,'securityacceptance_date'=>$Securityacceptance_date,'letternumber'=>$Letternumber,'letter_date'=>$Letter_date,'last_servicestatus_fid'=>$Last_servicestatus_fid,'deletetime'=>-1]);
return response()->json($Servicerequest, 201);
}
public function update($id,Request $request)
    {
    
$Title=$request->get('title');
$Role_systemuser_fid=$request->get('role_systemuser_fid');
$Unit_fid=$request->get('unit_fid');
$Servicetype_fid=$request->get('servicetype_fid');
$Description=$request->get('description');
$Priority=$request->get('priority');
$File1_flu=$request->get('file1_flu');
$Request_date=$request->get('request_date');
$Letterfile_flu=$request->get('letterfile_flu');
$Securityacceptor_role_systemuser_fid=$request->get('securityacceptor_role_systemuser_fid');
$Is_securityaccepted=$request->get('is_securityaccepted');
$Securityacceptancemessage=$request->get('securityacceptancemessage');
$Securityacceptance_date=$request->get('securityacceptance_date');
$Letternumber=$request->get('letternumber');
$Letter_date=$request->get('letter_date');
$Last_servicestatus_fid=$request->get('last_servicestatus_fid');
$Servicerequest = new itsap_servicerequest();
$Servicerequest = $Servicerequest->find($id);
$Servicerequest->title=$Title;
$Servicerequest->role_systemuser_fid=$Role_systemuser_fid;
$Servicerequest->unit_fid=$Unit_fid;
$Servicerequest->servicetype_fid=$Servicetype_fid;
$Servicerequest->description=$Description;
$Servicerequest->priority=$Priority;
$Servicerequest->file1_flu=$File1_flu;
$Servicerequest->request_date=$Request_date;
$Servicerequest->letterfile_flu=$Letterfile_flu;
$Servicerequest->securityacceptor_role_systemuser_fid=$Securityacceptor_role_systemuser_fid;
$Servicerequest->is_securityaccepted=$Is_securityaccepted;
$Servicerequest->securityacceptancemessage=$Securityacceptancemessage;
$Servicerequest->securityacceptance_date=$Securityacceptance_date;
$Servicerequest->letternumber=$Letternumber;
$Servicerequest->letter_date=$Letter_date;
$Servicerequest->last_servicestatus_fid=$Last_servicestatus_fid;
$Servicerequest->save();
return response()->json($Servicerequest, 201);
}
public function list()
{
$Servicerequest = itsap_servicerequest::all();
return response()->json($Servicerequest, 201);
}
public function get($id,Request $request)
{
$Servicerequest = itsap_servicerequest::find($id);
return response()->json($Servicerequest, 201);
}
public function delete($id,Request $request)
{
$Servicerequest = itsap_servicerequest::find($id);
$Servicerequest->delete();
return response()->json(['message'=>'deleted'], 201);
}
}