<?php
namespace App\Http\Controllers\ifi\API;
use App\models\ifi\ifi_employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

public function add(Request $request)
    {
    
$Name=$request->input('name');
$Family=$request->input('family');
$Fathername=$request->input('fathername');
$Ismale=$request->input('ismale');
$Mellicode=$request->input('mellicode');
$Shsh=$request->input('shsh');
$Shshserial=$request->input('shshserial');
$Personelcode=$request->input('personelcode');
$Employmentcode=$request->input('employmentcode');
$Role_fid=$request->input('role_fid');
$Nationality_fid=$request->input('nationality_fid');
$Paycenter_fid=$request->input('paycenter_fid');
$Employmenttype_fid=$request->input('employmenttype_fid');
$Born_date=$request->input('born_date');
$Childcount=$request->input('childcount');
$Ismarried=$request->input('ismarried');
$Mobile=$request->input('mobile');
$Tel=$request->input('tel');
$Address=$request->input('address');
$Zipcode=$request->input('zipcode');
$Common_city_fid=$request->input('common_city_fid');
$Accountnumber=$request->input('accountnumber');
$Cardnumber=$request->input('cardnumber');
$Bank_fid=$request->input('bank_fid');
$Is_neededinsurance=$request->input('is_neededinsurance');
$Is_payabale=$request->input('is_payabale');
$Passportnumber=$request->input('passportnumber');
$Passportserial=$request->input('passportserial');
$Education=$request->input('education');
$Entrance_date=$request->input('entrance_date');
$Visatype_fid=$request->input('visatype_fid');
$Visaexpire_date=$request->input('visaexpire_date');
$Employee = ifi_employee::create(['name'=>$Name,'family'=>$Family,'fathername'=>$Fathername,'ismale'=>$Ismale,'mellicode'=>$Mellicode,'shsh'=>$Shsh,'shshserial'=>$Shshserial,'personelcode'=>$Personelcode,'employmentcode'=>$Employmentcode,'role_fid'=>$Role_fid,'nationality_fid'=>$Nationality_fid,'paycenter_fid'=>$Paycenter_fid,'employmenttype_fid'=>$Employmenttype_fid,'born_date'=>$Born_date,'childcount'=>$Childcount,'ismarried'=>$Ismarried,'mobile'=>$Mobile,'tel'=>$Tel,'address'=>$Address,'zipcode'=>$Zipcode,'common_city_fid'=>$Common_city_fid,'accountnumber'=>$Accountnumber,'cardnumber'=>$Cardnumber,'bank_fid'=>$Bank_fid,'is_neededinsurance'=>$Is_neededinsurance,'is_payabale'=>$Is_payabale,'passportnumber'=>$Passportnumber,'passportserial'=>$Passportserial,'education'=>$Education,'entrance_date'=>$Entrance_date,'visatype_fid'=>$Visatype_fid,'visaexpire_date'=>$Visaexpire_date,'deletetime'=>-1]);
return response()->json($Employee, 201);
}
public function update($id,Request $request)
    {
    
$Name=$request->get('name');
$Family=$request->get('family');
$Fathername=$request->get('fathername');
$Ismale=$request->get('ismale');
$Mellicode=$request->get('mellicode');
$Shsh=$request->get('shsh');
$Shshserial=$request->get('shshserial');
$Personelcode=$request->get('personelcode');
$Employmentcode=$request->get('employmentcode');
$Role_fid=$request->get('role_fid');
$Nationality_fid=$request->get('nationality_fid');
$Paycenter_fid=$request->get('paycenter_fid');
$Employmenttype_fid=$request->get('employmenttype_fid');
$Born_date=$request->get('born_date');
$Childcount=$request->get('childcount');
$Ismarried=$request->get('ismarried');
$Mobile=$request->get('mobile');
$Tel=$request->get('tel');
$Address=$request->get('address');
$Zipcode=$request->get('zipcode');
$Common_city_fid=$request->get('common_city_fid');
$Accountnumber=$request->get('accountnumber');
$Cardnumber=$request->get('cardnumber');
$Bank_fid=$request->get('bank_fid');
$Is_neededinsurance=$request->get('is_neededinsurance');
$Is_payabale=$request->get('is_payabale');
$Passportnumber=$request->get('passportnumber');
$Passportserial=$request->get('passportserial');
$Education=$request->get('education');
$Entrance_date=$request->get('entrance_date');
$Visatype_fid=$request->get('visatype_fid');
$Visaexpire_date=$request->get('visaexpire_date');
$Employee = new ifi_employee();
$Employee = $Employee->find($id);
$Employee->name=$Name;
$Employee->family=$Family;
$Employee->fathername=$Fathername;
$Employee->ismale=$Ismale;
$Employee->mellicode=$Mellicode;
$Employee->shsh=$Shsh;
$Employee->shshserial=$Shshserial;
$Employee->personelcode=$Personelcode;
$Employee->employmentcode=$Employmentcode;
$Employee->role_fid=$Role_fid;
$Employee->nationality_fid=$Nationality_fid;
$Employee->paycenter_fid=$Paycenter_fid;
$Employee->employmenttype_fid=$Employmenttype_fid;
$Employee->born_date=$Born_date;
$Employee->childcount=$Childcount;
$Employee->ismarried=$Ismarried;
$Employee->mobile=$Mobile;
$Employee->tel=$Tel;
$Employee->address=$Address;
$Employee->zipcode=$Zipcode;
$Employee->common_city_fid=$Common_city_fid;
$Employee->accountnumber=$Accountnumber;
$Employee->cardnumber=$Cardnumber;
$Employee->bank_fid=$Bank_fid;
$Employee->is_neededinsurance=$Is_neededinsurance;
$Employee->is_payabale=$Is_payabale;
$Employee->passportnumber=$Passportnumber;
$Employee->passportserial=$Passportserial;
$Employee->education=$Education;
$Employee->entrance_date=$Entrance_date;
$Employee->visatype_fid=$Visatype_fid;
$Employee->visaexpire_date=$Visaexpire_date;
$Employee->save();
return response()->json($Employee, 201);
}
public function list()
{
$Employee = ifi_employee::all();
return response()->json($Employee, 201);
}
public function get($id,Request $request)
{
$Employee = ifi_employee::find($id);
return response()->json($Employee, 201);
}
public function delete($id,Request $request)
{
$Employee = ifi_employee::find($id);
$Employee->delete();
return response()->json(['message'=>'deleted'], 201);
}
}