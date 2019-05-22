<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_activity extends Model
{
    protected $table = "ifi_activity";
    protected $fillable = ['title','paycenter_type','planingcode','taxtype_fid','alalhesab','isactive'];
}