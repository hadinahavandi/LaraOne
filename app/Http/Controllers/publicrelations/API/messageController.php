<?php
namespace App\Http\Controllers\publicrelations\API;
use App\models\publicrelations\publicrelations_message;
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
use App\Http\Requests\publicrelations\message\publicrelations_messageAddRequest;
use App\Http\Requests\publicrelations\message\publicrelations_messageUpdateRequest;
use App\Http\Requests\publicrelations\message\publicrelations_messageListRequest;

class MessageController extends SweetController
{
    private $ModuleName='publicrelations';

	public function add(publicrelations_messageAddRequest $request)
    {
        //if(!Bouncer::can('publicrelations.message.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Message = new publicrelations_message();
        $Message->name=$request->getName();
        $Message->email=$request->getEmail();
        $Message->phone_bnum=$request->getPhonebnum();
        $Message->messagetext_te=$request->getMessagetextte();
		$Message->save();
		return response()->json(['Data'=>$Message], 201);
	}
	public function update($id,publicrelations_messageUpdateRequest $request)
    {
        if(!Bouncer::can('publicrelations.message.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Message = new publicrelations_message();
        $Message = publicrelations_message::find($id);
        $Message->name=$request->getName();
        $Message->email=$request->getEmail();
        $Message->phone_bnum=$request->getPhonebnum();
        $Message->messagetext_te=$request->getMessagetextte();
        $Message->save();
        return response()->json(['Data'=>$Message], 202);
    }
    public function list(publicrelations_messageListRequest $request)
    {

        Bouncer::allow('admin')->to('publicrelations.message.insert');
        Bouncer::allow('admin')->to('publicrelations.message.edit');
        Bouncer::allow('admin')->to('publicrelations.message.list');
        Bouncer::allow('admin')->to('publicrelations.message.view');
        Bouncer::allow('admin')->to('publicrelations.message.delete');

        //if(!Bouncer::can('publicrelations.message.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $MessageQuery = publicrelations_message::where('id','>=','0');
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'name',$SearchText);
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'name',$request->get('name'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'email',$request->get('email'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'phone_bnum',$request->get('phonebnum'));
        $MessageQuery =SweetQueryBuilder::WhereLikeIfNotNull($MessageQuery,'messagetext_te',$request->get('messagetextte'));
        $MessageQuery = SweetQueryBuilder::orderByFields($MessageQuery, $request->getOrderFields());
        $MessagesCount=$MessageQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$MessagesCount], 200);
        $Messages=SweetQueryBuilder::setPaginationIfNotNull($MessageQuery,$request->getStartRow(),$request->getPageSize())->get();
        $MessagesArray=[];
        for($i=0;$i<count($Messages);$i++)
        {
            $MessagesArray[$i]=$Messages[$i]->toArray();
        }
        $Message = $this->getNormalizedList($MessagesArray);
        return response()->json(['Data'=>$Message,'RecordCount'=>$MessagesCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('publicrelations.message.view'))
            //throw new AccessDeniedHttpException();
        $Message=publicrelations_message::find($id);
        $MessageObjectAsArray=$Message->toArray();
        $Message = $this->getNormalizedItem($MessageObjectAsArray);
        return response()->json(['Data'=>$Message], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('publicrelations.message.delete'))
            throw new AccessDeniedHttpException();
        $Message = publicrelations_message::find($id);
        $Message->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}