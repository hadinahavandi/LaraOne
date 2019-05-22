<?php

namespace App\Http\Controllers\contactus\API;

use App\models\contactus\contactus_message;
use App\Http\Controllers\Controller;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MessageController extends SweetController
{

    public function add(Request $request)
    {

        $Messagereceiver = $request->input('messagereceiver');

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
        $Answertext = $request->input('answertext');
        $Answertext=$Answertext!=null? $Answertext : '';
        $Answerflu = $request->file('answerflu');
        if ($Answerflu != null) {
            $Answerflu->move('img/', $Answerflu->getClientOriginalName());
            $Answerflu = 'img/' . $Answerflu->getClientOriginalName();
        } else {
            $Answerflu = '';
        }
        $Message = contactus_message::create(['messagereceiver_fid' => $Messagereceiver, 'orderserial' => $Orderserial, 'questiontext' => $Questiontext, 'question_flu' => $Questionflu, 'sendername' => $Sendername, 'sendertel' => $Sendertel, 'answertext' => $Answertext, 'answer_flu' => $Answerflu, 'deletetime' => -1]);
        return response()->json(['Data' =>$Message], 201);

    }

    public function update($id, Request $request)
    {
        if(!Bouncer::can('message.edit'))
            throw new AccessDeniedHttpException();
            $Answertext = $request->get('answertext');
            $Answerflu = $request->file('answerflu');
            if ($Answerflu != null) {
                $Answerflu->move('img/', $Answerflu->getClientOriginalName());
                $Answerflu = 'img/' . $Answerflu->getClientOriginalName();
            } else {
                $Answerflu = '';
            }
            $Message = new contactus_message();
            $Message = $Message->find($id);
            $Message->answertext = $Answertext;
            if ($Answerflu != null)
                $Message->answer_flu = $Answerflu;
            $Message->save();
            return response()->json(['Data' => $Message], 202);


    }
    public function list()
    {
        Bouncer::allow('admin')->to('message.edit');
        $Message = $this->getNormalizedList(contactus_message::all()->toArray());
        return response()->json(['Data' => $Message, 'RecordCount' => count($Message)], 200);
    }

    public function get($id, Request $request)
    {
        $Message = $this->getNormalizedItem(contactus_message::find($id)->toArray());
        return response()->json(['Data' => $Message], 200);
    }

    public function Find($OrderSerial, Request $request)
    {
        $Message = $this->getNormalizedItem(contactus_message::where('orderserial', '=', $OrderSerial)->firstOrFail()->toArray());
        return response()->json(['Data' => $Message], 200);
    }
    public function delete($id, Request $request)
    {
        $Message = contactus_message::find($id);
        $Message->delete();
        return response()->json(['message' => 'deleted'], 202);
    }
}