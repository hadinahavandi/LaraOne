<?php

namespace App\models\trapp;

use App\models\finance\finance_transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_order extends Model
{
    protected $table = "trapp_order";
    protected $fillable = ['price_prc', 'reserve__finance_transaction_fid', 'cancel__finance_transaction_fid', 'villa_fid', 'orderstatus_fid', 'start_date', 'duration_num', 'user_fid'];

    public function reservefinancetransaction()
    {
        return $this->belongsTo(finance_transaction::class, 'reserve__finance_transaction_fid')->first();
    }

    public function cancelfinancetransaction()
    {
        return $this->belongsTo(finance_transaction::class, 'cancel__finance_transaction_fid')->first();
    }

    public function villa()
    {
        return $this->belongsTo(trapp_villa::class, 'villa_fid')->first();
    }

    public function orderstatus()
    {
        return $this->belongsTo(trapp_orderstatus::class, 'orderstatus_fid')->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_fid')->first();
    }
}