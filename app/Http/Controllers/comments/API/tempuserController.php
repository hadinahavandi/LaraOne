<?php
namespace App\Http\Controllers\comments\API;
use App\models\comments\comments_tempuser;
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
use App\Http\Requests\comments\comments_tempuserAddRequest;
use App\Http\Requests\comments\comments_tempuserUpdateRequest;

class TempuserController extends SweetController
{
    private $ModuleName='comments';

	public function add(comments_tempuserAddRequest $request)
    {
        if(!Bouncer::can('comments.tempuser.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputName=$request->input('name',' ');
		$InputFamily=$request->input('family',' ');
		$InputMobilenum=$request->input('mobilenum',0);
		$InputEmail=$request->input('email',' ');
		$InputTelnum=$request->input('telnum',0);
    
		$Tempuser = comments_tempuser::create(['name'=>$InputName,'family'=>$InputFamily,'mobile_num'=>$InputMobilenum,'email'=>$InputEmail,'tel_num'=>$InputTelnum,'deletetime'=>-1]);
		return response()->json(['Data'=>$Tempuser], 201);
	}
	public function update($id,comments_tempuserUpdateRequest $request)
    {
        if(!Bouncer::can('comments.tempuser.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputName=$request->get('name',' ');
		$InputFamily=$request->get('family',' ');
		$InputMobilenum=$request->get('mobilenum',0);
		$InputEmail=$request->get('email',' ');
		$InputTelnum=$request->get('telnum',0);;
            
    
        $Tempuser = new comments_tempuser();
        $Tempuser = $Tempuser->find($id);
        $Tempuser->name=$InputName;
        $Tempuser->family=$InputFamily;
        $Tempuser->mobile_num=$InputMobilenum;
        $Tempuser->email=$InputEmail;
        $Tempuser->tel_num=$InputTelnum;
        $Tempuser->save();
        return response()->json(['Data'=>$Tempuser], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('comments.tempuser.insert');
        Bouncer::allow('admin')->to('comments.tempuser.edit');
        Bouncer::allow('admin')->to('comments.tempuser.list');
        Bouncer::allow('admin')->to('comments.tempuser.view');
        Bouncer::allow('admin')->to('comments.tempuser.delete');
        //if(!Bouncer::can('comments.tempuser.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $TempuserQuery = comments_tempuser::where('id','>=','0');
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'family',$SearchText);
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'name',$request->get('name'));
        $TempuserQuery =SweetQueryBuilder::OrderIfNotNull($TempuserQuery,'name__sort','name',$request->get('name__sort'));
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'family',$request->get('family'));
        $TempuserQuery =SweetQueryBuilder::OrderIfNotNull($TempuserQuery,'family__sort','family',$request->get('family__sort'));
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'mobile_num',$request->get('mobilenum'));
        $TempuserQuery =SweetQueryBuilder::OrderIfNotNull($TempuserQuery,'mobilenum__sort','mobile_num',$request->get('mobilenum__sort'));
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'email',$request->get('email'));
        $TempuserQuery =SweetQueryBuilder::OrderIfNotNull($TempuserQuery,'email__sort','email',$request->get('email__sort'));
        $TempuserQuery =SweetQueryBuilder::WhereLikeIfNotNull($TempuserQuery,'tel_num',$request->get('telnum'));
        $TempuserQuery =SweetQueryBuilder::OrderIfNotNull($TempuserQuery,'telnum__sort','tel_num',$request->get('telnum__sort'));
        $TempusersCount=$TempuserQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$TempusersCount], 200);
        $Tempusers=SweetQueryBuilder::setPaginationIfNotNull($TempuserQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $TempusersArray=[];
        for($i=0;$i<count($Tempusers);$i++)
        {
            $TempusersArray[$i]=$Tempusers[$i]->toArray();
        }
        $Tempuser = $this->getNormalizedList($TempusersArray);
        return response()->json(['Data'=>$Tempuser,'RecordCount'=>$TempusersCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('comments.tempuser.view'))
            //throw new AccessDeniedHttpException();
        $Tempuser=comments_tempuser::find($id);
        $TempuserObjectAsArray=$Tempuser->toArray();
        $Tempuser = $this->getNormalizedItem($TempuserObjectAsArray);
        return response()->json(['Data'=>$Tempuser], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('comments.tempuser.delete'))
            throw new AccessDeniedHttpException();
        $Tempuser = comments_tempuser::find($id);
        $Tempuser->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}