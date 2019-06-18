<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VerificationInfo extends Model
{
    protected $table = "users_verificationinfo";
    protected $fillable = ['phone', 'code', 'user_fid'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fid')->first();
    }

}
