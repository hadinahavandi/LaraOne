<?php
namespace App\models\contactus;

use Illuminate\Database\Eloquent\Model;

class contactus_messagereceiver extends Model
{
    protected $table = "contactus_messagereceiver";
    protected $fillable = ['name','user_id'];
}