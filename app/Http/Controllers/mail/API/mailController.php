<?php
namespace App\Http\Controllers\mail\API;
use App\models\mail\mail_mail;
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
use App\Http\Requests\mail\mail\mail_mailAddRequest;
use App\Http\Requests\mail\mail\mail_mailUpdateRequest;
use App\Http\Requests\mail\mail\mail_mailListRequest;

class MailController extends SweetController
{
    private $ModuleName='mail';

	public function add(mail_mailAddRequest $request)
    {
        //if(!Bouncer::can('mail.mail.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Mail = new mail_mail();
        $Mail->mailpost_fid=$request->getMailpost();
        $Mail->email=$request->getEmail();
        $Mail->mailstatus_fid=$request->getMailstatus();
		$Mail->save();
		return response()->json(['Data'=>$Mail], 201);
	}
	public function update($id,mail_mailUpdateRequest $request)
    {
        if(!Bouncer::can('mail.mail.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Mail = new mail_mail();
        $Mail = mail_mail::find($id);
        $Mail->mailpost_fid=$request->getMailpost();
        $Mail->email=$request->getEmail();
        $Mail->mailstatus_fid=$request->getMailstatus();
        $Mail->save();
        return response()->json(['Data'=>$Mail], 202);
    }
    public function list(mail_mailListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('mail.mail.insert');
        Bouncer::allow('admin')->to('mail.mail.edit');
        Bouncer::allow('admin')->to('mail.mail.list');
        Bouncer::allow('admin')->to('mail.mail.view');
        Bouncer::allow('admin')->to('mail.mail.delete');
        */
        //if(!Bouncer::can('mail.mail.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $MailQuery = mail_mail::where('id','>=','0');
        $MailQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailQuery,'email',$SearchText);
        $MailQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailQuery,'mailpost_fid',$request->get('mailpost'));
        $MailQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailQuery,'email',$request->get('email'));
        $MailQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailQuery,'mailstatus_fid',$request->get('mailstatus'));
        $MailQuery = SweetQueryBuilder::orderByFields($MailQuery, $request->getOrderFields());
        $MailsCount=$MailQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$MailsCount], 200);
        $Mails=SweetQueryBuilder::setPaginationIfNotNull($MailQuery,$request->getStartRow(),$request->getPageSize())->get();
        $MailsArray=[];
        for($i=0;$i<count($Mails);$i++)
        {
            $MailsArray[$i]=$Mails[$i]->toArray();
            $MailpostField=$Mails[$i]->mailpost();
            $MailsArray[$i]['mailpostcontent']=$MailpostField==null?'':$MailpostField->name;
            $MailstatusField=$Mails[$i]->mailstatus();
            $MailsArray[$i]['mailstatuscontent']=$MailstatusField==null?'':$MailstatusField->name;
        }
        $Mail = $this->getNormalizedList($MailsArray);
        return response()->json(['Data'=>$Mail,'RecordCount'=>$MailsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('mail.mail.view'))
            //throw new AccessDeniedHttpException();
        $Mail=mail_mail::find($id);
        $MailObjectAsArray=$Mail->toArray();
        $MailpostObject=$Mail->mailpost();
        $MailpostObject=$MailpostObject==null?'':$MailpostObject;
        $MailObjectAsArray['mailpostinfo']=$this->getNormalizedItem($MailpostObject->toArray());
        $MailstatusObject=$Mail->mailstatus();
        $MailstatusObject=$MailstatusObject==null?'':$MailstatusObject;
        $MailObjectAsArray['mailstatusinfo']=$this->getNormalizedItem($MailstatusObject->toArray());
        $Mail = $this->getNormalizedItem($MailObjectAsArray);
        return response()->json(['Data'=>$Mail], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('mail.mail.delete'))
            throw new AccessDeniedHttpException();
        $Mail = mail_mail::find($id);
        $Mail->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}