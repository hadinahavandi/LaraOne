<?php
namespace App\Http\Controllers\posts\API;
use App\models\posts\posts_postcategory;
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
use App\Http\Requests\posts\postcategory\posts_postcategoryAddRequest;
use App\Http\Requests\posts\postcategory\posts_postcategoryUpdateRequest;
use App\Http\Requests\posts\postcategory\posts_postcategoryListRequest;

class PostcategoryController extends SweetController
{
    private $ModuleName='posts';

	public function add(posts_postcategoryAddRequest $request)
    {
        //if(!Bouncer::can('posts.postcategory.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Postcategory = new posts_postcategory();
        $Postcategory->post_fid=$request->getPost();
        $Postcategory->category_fid=$request->getCategory();
		$Postcategory->save();
		return response()->json(['Data'=>$Postcategory], 201);
	}
	public function update($id,posts_postcategoryUpdateRequest $request)
    {
        if(!Bouncer::can('posts.postcategory.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Postcategory = new posts_postcategory();
        $Postcategory = posts_postcategory::find($id);
        $Postcategory->post_fid=$request->getPost();
        $Postcategory->category_fid=$request->getCategory();
        $Postcategory->save();
        return response()->json(['Data'=>$Postcategory], 202);
    }
    public function list(posts_postcategoryListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('posts.postcategory.insert');
        Bouncer::allow('admin')->to('posts.postcategory.edit');
        Bouncer::allow('admin')->to('posts.postcategory.list');
        Bouncer::allow('admin')->to('posts.postcategory.view');
        Bouncer::allow('admin')->to('posts.postcategory.delete');
        */
        //if(!Bouncer::can('posts.postcategory.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $PostcategoryQuery = posts_postcategory::where('id','>=','0');
        $PostcategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostcategoryQuery,'post_fid',$SearchText);
        $PostcategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostcategoryQuery,'post_fid',$request->get('post'));
        $PostcategoryQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostcategoryQuery,'category_fid',$request->get('category'));
        $PostcategoryQuery = SweetQueryBuilder::orderByFields($PostcategoryQuery, $request->getOrderFields());
        $PostcategorysCount=$PostcategoryQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$PostcategorysCount], 200);
        $Postcategorys=SweetQueryBuilder::setPaginationIfNotNull($PostcategoryQuery,$request->getStartRow(),$request->getPageSize())->get();
        $PostcategorysArray=[];
        for($i=0;$i<count($Postcategorys);$i++)
        {
            $PostcategorysArray[$i]=$Postcategorys[$i]->toArray();
            $PostField=$Postcategorys[$i]->post();
            $PostcategorysArray[$i]['postcontent']=$PostField==null?'':$PostField->name;
            $CategoryField=$Postcategorys[$i]->category();
            $PostcategorysArray[$i]['categorycontent']=$CategoryField==null?'':$CategoryField->name;
        }
        $Postcategory = $this->getNormalizedList($PostcategorysArray);
        return response()->json(['Data'=>$Postcategory,'RecordCount'=>$PostcategorysCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('posts.postcategory.view'))
            //throw new AccessDeniedHttpException();
        $Postcategory=posts_postcategory::find($id);
        $PostcategoryObjectAsArray=$Postcategory->toArray();
        $PostObject=$Postcategory->post();
        $PostObject=$PostObject==null?'':$PostObject;
        $PostcategoryObjectAsArray['postinfo']=$this->getNormalizedItem($PostObject->toArray());
        $CategoryObject=$Postcategory->category();
        $CategoryObject=$CategoryObject==null?'':$CategoryObject;
        $PostcategoryObjectAsArray['categoryinfo']=$this->getNormalizedItem($CategoryObject->toArray());
        $Postcategory = $this->getNormalizedItem($PostcategoryObjectAsArray);
        return response()->json(['Data'=>$Postcategory], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('posts.postcategory.delete'))
            throw new AccessDeniedHttpException();
        $Postcategory = posts_postcategory::find($id);
        $Postcategory->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}