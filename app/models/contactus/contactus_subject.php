<?php
namespace App\models\contactus;

use Illuminate\Database\Eloquent\Model;

class contactus_subject extends Model
{
    protected $table = "contactus_subject";
    protected $fillable = ['name'];
}