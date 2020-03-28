<?php
namespace App\Http\Controllers\posts\API;
use App\models\posts\posts_category;
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
use App\Http\Requests\posts\category\posts_categoryAddRequest;
use App\Http\Requests\posts\category\posts_categoryUpdateRequest;
use App\Http\Requests\posts\category\posts_categoryListRequest;

class CategoryController extends SweetController
{
    private $ModuleName='posts';

	public function add(posts_categoryAddRequest $request)
    {
        //if(!Bouncer::can('posts.category.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Category = new posts_category();
        $Category->name=$request->getName();
        $Category->latinname=$request->getLatinname();
        $Category->mother__category_fid=$request->getMothercategory();
		$Category->save();
		return response()->json(['Data'=>$Category], 201);
	}
	public function update($id,posts_categoryUpdateRequest $request)
    {
        if(!Bouncer::can('posts.category.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Category = new posts_category();
        $Category = posts_category::find($id);
        $Category->name=$request->getName();
        $Category->latinname=$request->getLatinname();
        $Category->mother__category_fid=$request->getMothercategory();
        $Category->save();
        return response()->json(['Data'=>$Category], 202);
    }
    public function list(posts_categoryListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('posts.category.insert');
        Bouncer::allow('admin')->to('posts.category.edit');
        Bouncer::allow('admin')->to('posts.category.list');
        Bouncer::allow('admin')->to('posts.category.view');
        Bouncer::allow('admin')->to('posts.category.delete');
        */
        //if(!Bouncer::can('posts.category.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $CategoryQuery = posts_category::where('id','>=','0');
        $CategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($CategoryQuery,'name',$SearchText);
        $CategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($CategoryQuery,'name',$request->get('name'));
        $CategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($CategoryQuery,'latinname',$request->get('latinname'));
        $CategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($CategoryQuery,'mother__category_fid',$request->get('mothercategory'));
        $CategoryQuery = SweetQueryBuilder::orderByFields($CategoryQuery, $request->getOrderFields());
        $CategorysCount=$CategoryQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$CategorysCount], 200);
        $Categorys=SweetQueryBuilder::setPaginationIfNotNull($CategoryQuery,$request->getStartRow(),$request->getPageSize())->get();
        $CategorysArray=[];
        for($i=0;$i<count($Categorys);$i++)
        {
            $CategorysArray[$i]=$Categorys[$i]->toArray();
            $MothercategoryField=$Categorys[$i]->mothercategory();
            $CategorysArray[$i]['mothercategorycontent']=$MothercategoryField==null?'':$MothercategoryField->name;
        }
        $Category = $this->getNormalizedList($CategorysArray);
        return response()->json(['Data'=>$Category,'RecordCount'=>$CategorysCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('posts.category.view'))
            //throw new AccessDeniedHttpException();
        $Category=posts_category::find($id);
        $CategoryObjectAsArray=$Category->toArray();
        $MothercategoryObject=$Category->mothercategory();
        $MothercategoryObject=$MothercategoryObject==null?'':$MothercategoryObject;
        $CategoryObjectAsArray['mothercategoryinfo']=$this->getNormalizedItem($MothercategoryObject->toArray());
        $Category = $this->getNormalizedItem($CategoryObjectAsArray);
        return response()->json(['Data'=>$Category], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('posts.category.delete'))
            throw new AccessDeniedHttpException();
        $Category = posts_category::find($id);
        $Category->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}