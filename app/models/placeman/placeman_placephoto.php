<?php

namespace App\models\placeman;

use App\User;
use Illuminate\Database\Eloquent\Model;

class placeman_placephoto extends Model
{
    protected $table = "placeman_placephoto";
    protected $fillable = ['name', 'photo_igu', 'phototype_fid', 'place_fid'];

    public function phototype()
    {
        return $this->belongsTo(placeman_phototype::class, 'phototype_fid')->first();
    }

    public function place()
    {
        return $this->belongsTo(placeman_place::class, 'place_fid')->first();
    }
}