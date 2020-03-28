<?php
namespace App\models\publicrelations;

use App\User;
use Illuminate\Database\Eloquent\Model;

class publicrelations_message extends Model
{
    protected $table = "publicrelations_message";
    protected $fillable = ['name','email','phone_bnum','messagetext_te'];
}