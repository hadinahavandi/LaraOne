<?php
namespace App\models\trapp;

use App\models\placeman\placeman_area;
use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_villaowner extends Model
{
    protected $table = "trapp_villaowner";
    protected $fillable = ['name', 'user_fid', 'nationalcode_bnum', 'address', 'shabacode_bnum', 'tel_bnum', 'backuptel_bnum', 'email', 'backupmobile_bnum', 'photo_igu', 'nationalcard_igu', 'placeman_area_fid'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_fid')->first();
    }
    public function placemanarea()
    {
        return $this->belongsTo(placeman_area::class, 'placeman_area_fid')->first();
    }

    public static function getUserVillaOwners($UserID)
    {

        return trapp_villaowner::where('user_fid', '=', $UserID)->get();
    }
}