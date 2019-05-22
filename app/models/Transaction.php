<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['amount','transactionid','status','user_id'];

}
