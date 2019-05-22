<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_paycenter extends Model
{
    protected $table = "ifi_paycenter";
    protected $fillable = ['title','chapter','accountingcode','paycenter_fid'];
}