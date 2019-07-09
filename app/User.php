<?php

namespace App;

use App\models\common\common_app;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use HasRolesAndAbilities;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'code', 'appuseridentifier', 'common_app_fid'
    ];

    public function CommonApp()
    {
        return $this->belongsTo(common_app::class, 'common_app_fid')->first();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
