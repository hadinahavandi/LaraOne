<?php
namespace App\Http\Controllers\mail\API;
use App\Jobs\SendEmailJob;
use App\models\mail\mail_mail;
use App\models\mail\mail_mailpost;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\mail\mailpost\mail_mailpostAddRequest;
use App\Http\Requests\mail\mailpost\mail_mailpostUpdateRequest;
use App\Http\Requests\mail\mailpost\mail_mailpostListRequest;

class MailpostController extends SweetController
{
    private $ModuleName='mail';

	public function add(mail_mailpostAddRequest $request)
    {
        //if(!Bouncer::can('mail.mailpost.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Mailpost = new mail_mailpost();
        $Mailpost->subject=$request->getSubject();
        $Mailpost->content_te=$request->getContentte();
        $Mailpost->name=$request->getName();
		$Mailpost->save();
		return response()->json(['Data'=>$Mailpost], 201);
	}
	public function update($id,mail_mailpostUpdateRequest $request)
    {
        if(!Bouncer::can('mail.mailpost.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Mailpost = new mail_mailpost();
        $Mailpost = mail_mailpost::find($id);
        $Mailpost->subject=$request->getSubject();
        $Mailpost->content_te=$request->getContentte();
        $Mailpost->name=$request->getName();
        $Mailpost->save();
        return response()->json(['Data'=>$Mailpost], 202);
    }
	public function sendToAll($id,Request $request)
    {
//        if(!Bouncer::can('mail.mailpost.send'))
//            throw new AccessDeniedHttpException();

        $mails=mail_mail::where('mailpost_fid','=',$id)->get();
        for ($i=0;$i<count($mails);$i++){
            $details['email'] = $mails[$i]->email;
            $details['mailpostid'] = $id;
            dispatch(new SendEmailJob($details));
        }
        return response()->json(['Data'=>'Sent'], 202);
    }
    public function list(mail_mailpostListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('mail.mailpost.insert');
        Bouncer::allow('admin')->to('mail.mailpost.edit');
        Bouncer::allow('admin')->to('mail.mailpost.list');
        Bouncer::allow('admin')->to('mail.mailpost.view');
        Bouncer::allow('admin')->to('mail.mailpost.delete');
        */
        //if(!Bouncer::can('mail.mailpost.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $MailpostQuery = mail_mailpost::where('id','>=','0');
        $MailpostQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailpostQuery,'name',$SearchText);
        $MailpostQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailpostQuery,'subject',$request->get('subject'));
        $MailpostQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailpostQuery,'content_te',$request->get('contentte'));
        $MailpostQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailpostQuery,'name',$request->get('name'));
        $MailpostQuery = SweetQueryBuilder::orderByFields($MailpostQuery, $request->getOrderFields());
        $MailpostsCount=$MailpostQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$MailpostsCount], 200);
        $Mailposts=SweetQueryBuilder::setPaginationIfNotNull($MailpostQuery,$request->getStartRow(),$request->getPageSize())->get();
        $MailpostsArray=[];
        for($i=0;$i<count($Mailposts);$i++)
        {
            $MailpostsArray[$i]=$Mailposts[$i]->toArray();
        }
        $Mailpost = $this->getNormalizedList($MailpostsArray);
        return response()->json(['Data'=>$Mailpost,'RecordCount'=>$MailpostsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('mail.mailpost.view'))
            //throw new AccessDeniedHttpException();
        $Mailpost=mail_mailpost::find($id);
        $MailpostObjectAsArray=$Mailpost->toArray();
        $Mailpost = $this->getNormalizedItem($MailpostObjectAsArray);
        return response()->json(['Data'=>$Mailpost], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('mail.mailpost.delete'))
            throw new AccessDeniedHttpException();
        $Mailpost = mail_mailpost::find($id);
        $Mailpost->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}