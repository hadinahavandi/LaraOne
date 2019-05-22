<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_employee extends Model
{
    protected $table = "ifi_employee";
    protected $fillable = ['name','family','fathername','ismale','mellicode','shsh','shshserial','personelcode','employmentcode','role_fid','nationality_fid','paycenter_fid','employmenttype_fid','born_date','childcount','ismarried','mobile','tel','address','zipcode','common_city_fid','accountnumber','cardnumber','bank_fid','is_neededinsurance','is_payabale','passportnumber','passportserial','education','entrance_date','visatype_fid','visaexpire_date'];
}