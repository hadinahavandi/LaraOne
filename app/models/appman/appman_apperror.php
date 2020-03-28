<?php
namespace App\models\appman;

use App\User;
use Illuminate\Database\Eloquent\Model;

class appman_apperror extends Model
{
    protected $table = "appman_apperror";
    protected $fillable = ['type','url','method','postingdata','receiveddata','error','line_num','appname','user_fid'
    ,'appversion','devicebrand','devicemodel','deviceos','deviceosversion'
    ];
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
}