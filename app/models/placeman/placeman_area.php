<?php

namespace App\models\placeman;

use Illuminate\Database\Eloquent\Model;

class placeman_area extends Model
{
    protected $table = "placeman_area";
    protected $fillable = ['title','city_id'];

    public function city()
    {
        return $this->belongsTo(placeman_city::class, 'city_id')->first();
    }
}
