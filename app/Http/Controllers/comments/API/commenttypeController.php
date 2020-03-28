<?php
namespace App\Http\Controllers\comments\API;
use App\models\comments\comments_commenttype;
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
use App\Http\Requests\comments\comments_commenttypeAddRequest;
use App\Http\Requests\comments\comments_commenttypeUpdateRequest;

class CommenttypeController extends SweetController
{
    private $ModuleName='comments';

	public function add(comments_commenttypeAddRequest $request)
    {
        if(!Bouncer::can('comments.commenttype.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputTitle=$request->input('title',' ');
		$InputRated=$request->input('rated',' ');
		$InputUniquecomment=$request->input('uniquecomment',' ');
    
		$Commenttype = comments_commenttype::create(['title'=>$InputTitle,'is_rated'=>$InputRated,'is_uniquecomment'=>$InputUniquecomment,'deletetime'=>-1]);
		return response()->json(['Data'=>$Commenttype], 201);
	}
	public function update($id,comments_commenttypeUpdateRequest $request)
    {
        if(!Bouncer::can('comments.commenttype.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputTitle=$request->get('title',' ');
		$InputRated=$request->get('rated',' ');
		$InputUniquecomment=$request->get('uniquecomment',' ');;
            
    
        $Commenttype = new comments_commenttype();
        $Commenttype = $Commenttype->find($id);
        $Commenttype->title=$InputTitle;
        $Commenttype->is_rated=$InputRated;
        $Commenttype->is_uniquecomment=$InputUniquecomment;
        $Commenttype->save();
        return response()->json(['Data'=>$Commenttype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('comments.commenttype.insert');
        Bouncer::allow('admin')->to('comments.commenttype.edit');
        Bouncer::allow('admin')->to('comments.commenttype.list');
        Bouncer::allow('admin')->to('comments.commenttype.view');
        Bouncer::allow('admin')->to('comments.commenttype.delete');
        //if(!Bouncer::can('comments.commenttype.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $CommenttypeQuery = comments_commenttype::where('id','>=','0');
        $CommenttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommenttypeQuery,'title',$SearchText);
        $CommenttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommenttypeQuery,'title',$request->get('title'));
        $CommenttypeQuery =SweetQueryBuilder::OrderIfNotNull($CommenttypeQuery,'title__sort','title',$request->get('title__sort'));
        $CommenttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommenttypeQuery,'is_rated',$request->get('rated'));
        $CommenttypeQuery =SweetQueryBuilder::OrderIfNotNull($CommenttypeQuery,'rated__sort','is_rated',$request->get('rated__sort'));
        $CommenttypeQuery =SweetQueryBuilder::WhereLikeIfNotNull($CommenttypeQuery,'is_uniquecomment',$request->get('uniquecomment'));
        $CommenttypeQuery =SweetQueryBuilder::OrderIfNotNull($CommenttypeQuery,'uniquecomment__sort','is_uniquecomment',$request->get('uniquecomment__sort'));
        $CommenttypesCount=$CommenttypeQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$CommenttypesCount], 200);
        $Commenttypes=SweetQueryBuilder::setPaginationIfNotNull($CommenttypeQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $CommenttypesArray=[];
        for($i=0;$i<count($Commenttypes);$i++)
        {
            $CommenttypesArray[$i]=$Commenttypes[$i]->toArray();
        }
        $Commenttype = $this->getNormalizedList($CommenttypesArray);
        return response()->json(['Data'=>$Commenttype,'RecordCount'=>$CommenttypesCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('comments.commenttype.view'))
            //throw new AccessDeniedHttpException();
        $Commenttype=comments_commenttype::find($id);
        $CommenttypeObjectAsArray=$Commenttype->toArray();
        $Commenttype = $this->getNormalizedItem($CommenttypeObjectAsArray);
        return response()->json(['Data'=>$Commenttype], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('comments.commenttype.delete'))
            throw new AccessDeniedHttpException();
        $Commenttype = comments_commenttype::find($id);
        $Commenttype->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}