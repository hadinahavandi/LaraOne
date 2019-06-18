<?php

namespace App\models\finance;

use App\User;
use Illuminate\Database\Eloquent\Model;

class finance_transaction extends Model
{
    protected $table = "finance_transaction";
    protected $fillable = ['amount_prc', 'transactionid', 'status', 'user_fid', 'description_te'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fid')->first();
    }
}