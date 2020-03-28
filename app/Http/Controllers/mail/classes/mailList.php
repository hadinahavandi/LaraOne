<?php


namespace App\Http\Controllers\mail\classes;


use App\models\mail\mail_mail;
use App\models\mail\mail_mailpost;

class mailList
{
    public static function makeMailList($MailArray){
        $mailPost=new mail_mailpost();
        $mailPost->name='';
        $mailPost->subject='';
        $mailPost->content_te='';
        $mailPost->save();
        for ($i=0;$i<count($MailArray);$i++){
            $Mail=new mail_mail();
            $Mail->mailpost_fid=$mailPost->id;
            $Mail->email=$MailArray[$i];
            $Mail->mailstatus_fid=1;
            $Mail->save();
        }
        return $mailPost->id;
    }
}