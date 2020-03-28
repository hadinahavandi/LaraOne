<?php
namespace App\Http\Controllers\mail\API;
use App\models\mail\mail_mailstatus;
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
use App\Http\Requests\mail\mailstatus\mail_mailstatusAddRequest;
use App\Http\Requests\mail\mailstatus\mail_mailstatusUpdateRequest;
use App\Http\Requests\mail\mailstatus\mail_mailstatusListRequest;

class MailstatusController extends SweetController
{
    private $ModuleName='mail';

	public function add(mail_mailstatusAddRequest $request)
    {
        //if(!Bouncer::can('mail.mailstatus.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Mailstatus = new mail_mailstatus();
        $Mailstatus->name=$request->getName();
		$Mailstatus->save();
		return response()->json(['Data'=>$Mailstatus], 201);
	}
	public function update($id,mail_mailstatusUpdateRequest $request)
    {
        if(!Bouncer::can('mail.mailstatus.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Mailstatus = new mail_mailstatus();
        $Mailstatus = mail_mailstatus::find($id);
        $Mailstatus->name=$request->getName();
        $Mailstatus->save();
        return response()->json(['Data'=>$Mailstatus], 202);
    }
    public function list(mail_mailstatusListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('mail.mailstatus.insert');
        Bouncer::allow('admin')->to('mail.mailstatus.edit');
        Bouncer::allow('admin')->to('mail.mailstatus.list');
        Bouncer::allow('admin')->to('mail.mailstatus.view');
        Bouncer::allow('admin')->to('mail.mailstatus.delete');
        */
        //if(!Bouncer::can('mail.mailstatus.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $MailstatusQuery = mail_mailstatus::where('id','>=','0');
        $MailstatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailstatusQuery,'name',$SearchText);
        $MailstatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($MailstatusQuery,'name',$request->get('name'));
        $MailstatusQuery = SweetQueryBuilder::orderByFields($MailstatusQuery, $request->getOrderFields());
        $MailstatussCount=$MailstatusQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$MailstatussCount], 200);
        $Mailstatuss=SweetQueryBuilder::setPaginationIfNotNull($MailstatusQuery,$request->getStartRow(),$request->getPageSize())->get();
        $MailstatussArray=[];
        for($i=0;$i<count($Mailstatuss);$i++)
        {
            $MailstatussArray[$i]=$Mailstatuss[$i]->toArray();
        }
        $Mailstatus = $this->getNormalizedList($MailstatussArray);
        return response()->json(['Data'=>$Mailstatus,'RecordCount'=>$MailstatussCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('mail.mailstatus.view'))
            //throw new AccessDeniedHttpException();
        $Mailstatus=mail_mailstatus::find($id);
        $MailstatusObjectAsArray=$Mailstatus->toArray();
        $Mailstatus = $this->getNormalizedItem($MailstatusObjectAsArray);
        return response()->json(['Data'=>$Mailstatus], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('mail.mailstatus.delete'))
            throw new AccessDeniedHttpException();
        $Mailstatus = mail_mailstatus::find($id);
        $Mailstatus->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}