<?php
namespace App\models\itsap;

use Illuminate\Database\Eloquent\Model;

class itsap_servicerequest extends Model
{
    protected $table = "itsap_servicerequest";
    protected $fillable = ['title','role_systemuser_fid','unit_fid','servicetype_fid','description','priority','file1_flu','request_date','letterfile_flu','securityacceptor_role_systemuser_fid','is_securityaccepted','securityacceptancemessage','securityacceptance_date','letternumber','letter_date','last_servicestatus_fid'];
}