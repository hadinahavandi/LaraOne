<?php

namespace App\models\placeman;

use App\User;
use Illuminate\Database\Eloquent\Model;

class placeman_place extends Model
{
    protected $table = "placeman_place";
    protected $fillable = ['title', 'logo_igu', 'description', 'isactive', 'address', 'area_fid', 'user_fid', 'latitude', 'longitude', 'visits'];

    public function area()
    {
        return $this->belongsTo(placeman_area::class, 'area_fid')->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fid')->first();
    }
}