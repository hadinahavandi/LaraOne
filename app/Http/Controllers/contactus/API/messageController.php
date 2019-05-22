<?php

namespace App\Http\Controllers\contactus\API;

use App\models\contactus\contactus_message;
use App\Http\Controllers\Controller;
use App\Sweet\SweetController;
use App\Sweet\SweetQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MessageController extends SweetController
{

    public function add(Request $request)
    {
//        if (!Bouncer::can('contactus.message.insert'))
//            throw new AccessDeniedHttpException();

        $Messagereceiver = 0;
        $number = mt_rand(1, 999999);
        $t=time();
        $random = $number.''.$t;
        $Orderserial =$random;
        $Questiontext = $request->input('questiontext');
        $Questiontext=$Questiontext!=null? $Questiontext : '';

        $Questionflu = $request->file('questionflu');
        if ($Questionflu != null) {
            $Questionflu->move('img/', $Questionflu->getClientOriginalName());
            $Questionflu = 'img/' . $Questionflu->getClientOriginalName();
        } else {
            $Questionflu = '';
        }
        $Sendername = $request->input('sendername');
        $Sendername=$Sendername!=null? $Sendername : '';

        $Sendertel = $request->input('sendertel');
        $Sendertel=$Sendertel!=null? $Sendertel : '';
        $Answertext = '';
        $Answerflu = '';
        $Unit = $request->input('unit');
        $Unit=$Unit!=null? $Unit : '-1';

        $Voiceflu = $request->file('voiceflu');
        if ($Voiceflu != null) {
            $Voiceflu->move('img/', $Voiceflu->getClientOriginalName());
            $Voiceflu = 'img/' . $Voiceflu->getClientOriginalName();
        } else {
            $Voiceflu = '';
        }
        $Personelno = $request->input('personelno');
        $Personelno=$Personelno!=null? $Personelno : '';

        $Degree=$request->input('degree');
        $Subject = $request->input('subject');
        $Message = contactus_message::create(['messagereceiver_fid' => $Messagereceiver, 'orderserial' => $Orderserial, 'questiontext' => $Questiontext, 'question_flu' => $Questionflu, 'sendername' => $Sendername, 'sendertel' => $Sendertel, 'answertext' => $Answertext, 'answer_flu' => $Answerflu, 'unit_fid' => $Unit, 'voice_flu' => $Voiceflu, 'personelno' => $Personelno, 'subject_fid' => $Subject, 'deletetime' => -1,'degree_fid'=>$Degree,'answervoice_flu' => '']);
        return response()->json(['Data' => $Message], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('contactus.message.edit'))
            throw new AccessDeniedHttpException();
        $Answertext = $request->get('answertext');
        $Answerflu = $request->file('answerflu');
        if ($Answerflu != null) {
            $Answerflu->move('img/', $Answerflu->getClientOriginalName());
            $Answerflu = 'img/' . $Answerflu->getClientOriginalName();
        } else {
            $Answerflu = '';
        }

        $Answervoiceflu=$request->file('answervoiceflu');
        if($Answervoiceflu!=null){
            $Answervoiceflu->move('img/',$Answervoiceflu->getClientOriginalName());
            $Answervoiceflu='img/'.$Answervoiceflu->getClientOriginalName();
        }
        else
        {
            $Answervoiceflu='';
        }
        $Message = new contactus_message();
        $Message = $Message->find($id);
        $Message->answertext = $Answertext;
        $Message->answervoice_flu = $Answervoiceflu;
        if ($Answerflu != null)
            $Message->answer_flu = $Answerflu;
        $Message->save();
        return response()->json(['Data' => $Message], 202);
    }


    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('contactus.message.insert');
        Bouncer::allow('admin')->to('contactus.message.edit');
        Bouncer::allow('admin')->to('contactus.message.list');
        Bouncer::allow('admin')->to('contactus.message.view');
        Bouncer::allow('admin')->to('contactus.message.delete');

        //if(!Bouncer::can('contactus.message.list'))
        //throw new AccessDeniedHttpException();
        $answered=$request->get('answered',2);
        $MessageQuery = contactus_message::where('id','>=','0');
        if($answered=="1")
            $MessageQuery=$MessageQuery->whereRaw('updated_at != created_at');
        if($answered=="0")
            $MessageQuery=$MessageQuery->whereRaw('updated_at = created_at');
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'messagereceiver_fid',$request->get('messagereceiver'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'orderserial',$request->get('orderserial'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'questiontext',$request->get('questiontext'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'sendername',$request->get('sendername'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'sendertel',$request->get('sendertel'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'answertext',$request->get('answertext'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'unit_fid',$request->get('unit'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'personelno',$request->get('personelno'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'subject_fid',$request->get('subject'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'degree_fid',$request->get('degree'));
        $Messages=$MessageQuery->get();
        $MessagesArray=[];
        for($i=0;$i<count($Messages);$i++)
        {
            $MessagesArray[$i]=$Messages[$i]->toArray();
            $Messagereceiver=$Messages[$i]->messagereceiver();
            $MessagesArray[$i]['messagereceivercontent']=$Messagereceiver==null?'':$Messagereceiver->name;
            $Unit=$Messages[$i]->unit();
            $MessagesArray[$i]['unitcontent']=$Unit==null?'':$Unit->name;
            $Subject=$Messages[$i]->subject();
            $MessagesArray[$i]['subjectcontent']=$Subject==null?'':$Subject->name;
            $Degree=$Messages[$i]->degree();
            $MessagesArray[$i]['degreecontent']=$Degree==null?'':$Degree->name;
        }
        $Message = $this->getNormalizedList($MessagesArray);
        return response()->json(['Data'=>$Message,'RecordCount'=>count($Message)], 200);
    }

    public function get($id, Request $request)
    {
//        if (!Bouncer::can('contactus.message.view'))
//            throw new AccessDeniedHttpException();

        $unit=contactus_message::find($id)->unit();
        $Message = $this->getNormalizedItem(contactus_message::find($id)->toArray());
        $log=(DB::getQueryLog());
        return response()->json(['Data' => $Message,'unit'=>$unit,'log'=>$log], 200);
    }
    public function Find($OrderSerial, Request $request)
    {
        $Message = $this->getNormalizedItem(contactus_message::where('orderserial', '=', $OrderSerial)->firstOrFail()->toArray());
        return response()->json(['Data' => $Message], 200);
    }
    public function delete($id, Request $request)
    {
        if (!Bouncer::can('contactus.message.delete'))
            throw new AccessDeniedHttpException();
        $Message = contactus_message::find($id);
        $Message->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}