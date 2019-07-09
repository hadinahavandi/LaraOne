<?php

namespace App\models\users;

use App\models\common\common_app;
use App\User;
use Illuminate\Database\Eloquent\Model;

class users_appregisterableroles extends Model
{
    protected $table = "users_appregisterableroles";
    protected $fillable = ['common_app_fid', 'rolename'];

    public function CommonApp()
    {
        return $this->belongsTo(common_app::class, 'common_app_fid')->first();
    }

}
