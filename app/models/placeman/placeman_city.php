<?php

namespace App\models\placeman;

use Illuminate\Database\Eloquent\Model;

class placeman_city extends Model
{
    protected $table = "placeman_city";
    protected $fillable = ['title','province_id'];

    public function province()
    {
        return $this->belongsTo(placeman_province::class, 'province_id')->first();
    }
}
