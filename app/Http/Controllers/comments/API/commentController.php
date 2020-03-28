<?php
namespace App\Http\Controllers\comments\API;
use App\models\comments\comments_comment;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\comments\comments_commentAddRequest;
use App\Http\Requests\comments\comments_commentUpdateRequest;

class CommentController extends SweetController
{
    private $ModuleName='comments';

	public function add(comments_commentAddRequest $request)
    {
//        if(!Bouncer::can('comments.comment.insert'))
//            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputText=$request->input('text',' ');
		$InputCommenttype=$request->input('commenttype',-1);
		$InputRatenum=$request->input('ratenum',0);
		$InputUser=Auth::user()->getAuthIdentifier();
		$InputSubjectentity=$request->input('subjectentity',-1);
		$Comment = comments_comment::create(['text'=>$InputText,'publish_time'=>"-1",'rate_num'=>$InputRatenum,'user_fid'=>$InputUser,'subjectentity_fid'=>$InputSubjectentity,'commenttype_fid'=>$InputCommenttype,'deletetime'=>-1]);
		return response()->json(['Data'=>$Comment], 201);
	}
	public function update($id,comments_commentUpdateRequest $request)
    {
        if(!Bouncer::can('comments.comment.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputText=$request->get('text',' ');
//		$InputCommenttype=$request->get('commenttype',-1);
		$InputRatenum=$request->get('ratenum',0);
        $Comment = new comments_comment();
        $Comment = $Comment->find($id);
        $Comment->text=$InputText;
//        $Comment->commenttype_fid=$InputCommenttype;
        if($InputRatenum>0)
            $Comment->rate_num=$InputRatenum;
        $Comment->save();
        return response()->json(['Data'=>$Comment], 202);
    }
    public function changePublishState($id,Request $request)
    {
//        if(!Bouncer::can('comments.comment.edit'))
//            throw new AccessDeniedHttpException();
        $InputPublishState=$request->get('publish',-1);
        $Comment = comments_comment::find($id);
        $Comment->publish_time=$InputPublishState>0?time():-1;
        $Comment->save();
        return response()->json(['Data'=>$Comment], 202);
    }
    public function list(Request $request)
    {
//        Bouncer::allow('admin')->to('comments.comment.insert');
//        Bouncer::allow('admin')->to('comments.comment.edit');
//        Bouncer::allow('admin')->to('comments.comment.list');
//        Bouncer::allow('admin')->to('comments.comment.view');
//        Bouncer::allow('admin')->to('comments.comment.delete');
        //if(!Bouncer::can('comments.comment.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $CommentQuery = comments_comment::where('id','>=','0');
        $hasOrder=false;
        if($request->get('text__sort')!=null || $request->get('ratenum__sort')!=null || $request->get('subjectentity__sort')!=null)
            $hasOrder=true;
            $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'text',$SearchText);
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'text',$request->get('text'));
        $CommentQuery =SweetQueryBuilder::OrderIfNotNull($CommentQuery,'text__sort','text',$request->get('text__sort'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'commenttype_fid',$request->get('commenttype'));
        $CommentQuery =SweetQueryBuilder::OrderIfNotNull($CommentQuery,'commenttype__sort','commenttype_fid',$request->get('commenttype__sort'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'publish_time',$request->get('publishtime'));
        $CommentQuery =SweetQueryBuilder::OrderIfNotNull($CommentQuery,'publishtime__sort','publish_time',$request->get('publishtime__sort'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'rate_num',$request->get('ratenum'));
        $CommentQuery =SweetQueryBuilder::OrderIfNotNull($CommentQuery,'ratenum__sort','rate_num',$request->get('ratenum__sort'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'tempuser_fid',$request->get('tempuser'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'mother_comment_fid',$request->get('mothercomment'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'user_fid',$request->get('user'));
        $CommentQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommentQuery,'subjectentity_fid',$request->get('subjectentity'));
        $CommentQuery =SweetQueryBuilder::OrderIfNotNull($CommentQuery,'subjectentity__sort','subjectentity_fid',$request->get('subjectentity__sort'));
        if(!$hasOrder)
            $CommentQuery=$CommentQuery->orderBy('id','desc');
        $CommentsCount=$CommentQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$CommentsCount], 200);
        $Comments=SweetQueryBuilder::setPaginationIfNotNull($CommentQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $CommentsArray=[];
        for($i=0;$i<count($Comments);$i++)
        {
            $CommentsArray[$i]=$Comments[$i]->toArray();
        }
        $Comment = $this->getNormalizedList($CommentsArray);
        return response()->json(['Data'=>$Comment,'RecordCount'=>$CommentsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('comments.comment.view'))
            //throw new AccessDeniedHttpException();
        $Comment=comments_comment::find($id);
        $CommentObjectAsArray=$Comment->toArray();
        $Comment = $this->getNormalizedItem($CommentObjectAsArray);
        return response()->json(['Data'=>$Comment], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('comments.comment.delete'))
            throw new AccessDeniedHttpException();
        $Comment = comments_comment::find($id);
        $Comment->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}