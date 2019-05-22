<?php

namespace App\models\contactus;

use Illuminate\Database\Eloquent\Model;

class contactus_message extends Model
{
    protected $table = "contactus_message";
    protected $fillable = ['messagereceiver_fid', 'orderserial', 'questiontext', 'question_flu', 'sendername', 'sendertel', 'answertext', 'voice_flu', 'answer_flu', 'unit_fid', 'answervoice_flu', 'personelno', 'subject_fid', 'degree_fid'];

    public function messagereceiver()
    {
        return $this->belongsTo(contactus_messagereceiver::class, 'messagereceiver_fid')->first();
    }

    public function unit()
    {
        return $this->belongsTo(contactus_unit::class, 'unit_fid')->first();
    }

    public function subject()
    {
        return $this->belongsTo(contactus_subject::class, 'subject_fid')->first();
    }

    public function degree()
    {
        return $this->belongsTo(contactus_degree::class, 'degree_fid')->first();
    }
}