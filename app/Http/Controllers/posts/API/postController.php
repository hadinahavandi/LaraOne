<?php
namespace App\Http\Controllers\posts\API;
use App\models\Category;
use App\models\posts\posts_category;
use App\models\posts\posts_post;
use App\Http\Controllers\Controller;
use App\models\posts\posts_postcategory;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostController extends SweetController
{

    public function add(Request $request)
    {
//        if(!Bouncer::can('posts.post.insert'))
//            throw new AccessDeniedHttpException();

        $InputTitle=$request->input('title');
        $InputSummaryte=$request->input('summaryte');
        $InputContentte=$request->input('contentte');
        $InputThumbnailflu=$request->file('thumbnailflu');
        $InputCategory=$request->input('category');
        if($InputThumbnailflu!=null){
            $InputThumbnailflu->move('img/',$InputThumbnailflu->getClientOriginalName());
            $InputThumbnailflu='img/'.$InputThumbnailflu->getClientOriginalName();
        }
        else
        {
            $InputThumbnailflu='';
        }
        $Post = posts_post::create(['title'=>$InputTitle,'summary_te'=>$InputSummaryte,'content_te'=>$InputContentte,'thumbnail_flu'=>$InputThumbnailflu,'deletetime'=>-1]);
        posts_postcategory::create(['post_fid'=>$Post,'category_fid'=>$InputCategory]);
        return response()->json(['Data'=>$Post], 201);
    }
    public function update($id,Request $request)
    {
        if(!Bouncer::can('posts.post.edit'))
            throw new AccessDeniedHttpException();

        $InputCategory=$request->input('category');
        $InputTitle=$request->get('title');
        $InputSummaryte=$request->get('summaryte');
        $InputContentte=$request->get('contentte');
        $InputThumbnailflu=$request->file('thumbnailflu');
        if($InputThumbnailflu!=null){
            $InputThumbnailflu->move('img/',$InputThumbnailflu->getClientOriginalName());
            $InputThumbnailflu='img/'.$InputThumbnailflu->getClientOriginalName();
        }
        else
        {
            $InputThumbnailflu='';
        }
        $PostCat=posts_postcategory::where('post_fid','=',$id)->get()[0];
        $PostCat->category_fid=$InputCategory;
        $PostCat->save();
        $Post = new posts_post();
        $Post = $Post->find($id);
        $Post->title=$InputTitle;
        $Post->summary_te=$InputSummaryte;
        $Post->content_te=$InputContentte;
        if($InputThumbnailflu!=null)
            $Post->thumbnail_flu=$InputThumbnailflu;
        $Post->save();
        return response()->json(['Data'=>$Post], 202);
    }
    public function list(Request $request)
    {
        return $this->listCatPosts(null,$request);
    }
    public function listCategoryPosts($catId,Request $request)
    {
        return $this->listCatPosts($catId,$request);
    }
    private function listCatPosts($catname,Request $request)
    {
        /*Bouncer::allow('admin')->to('posts.post.insert');
        Bouncer::allow('admin')->to('posts.post.edit');
        Bouncer::allow('admin')->to('posts.post.list');
        Bouncer::allow('admin')->to('posts.post.view');
        Bouncer::allow('admin')->to('posts.post.delete');
        */
        //if(!Bouncer::can('posts.post.list'))
        //  throw new AccessDeniedHttpException();
        $PostQuery = posts_postcategory::join('posts_category', 'posts_category.id', '=', 'posts_postcategory.category_fid');
        $PostQuery=$PostQuery->join('posts_post', 'posts_post.id', '=', 'posts_postcategory.post_fid');
        if($catname!=null){
            $subCats=posts_category::getCatNameSubCats($catname);
            $PostQuery=$PostQuery->where(function ($query) use ($subCats) {
                $query->where('category_fid','=',$subCats[0]);
                for($i=1;$i<count($subCats);$i++){
                    $query->orWhere('category_fid','=',$subCats[$i]);
                }
            });
        }
        $PostQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostQuery,'title',$request->get('title'));
        $PostQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostQuery,'summary_te',$request->get('summaryte'));
        $PostQuery =SweetQueryBuilder::WhereLikeIfNotNull($PostQuery,'content_te',$request->get('contentte'));
        $Posts=$PostQuery->get();
        $PostsArray=[];
        for($i=0;$i<count($Posts);$i++)
        {
            $PostsArray[$i]=$Posts[$i]->toArray();
        }
        $Post = $this->getNormalizedList($PostsArray);
        return response()->json(['Data'=>$Post,'RecordCount'=>count($Post)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('posts.post.view'))
        //throw new AccessDeniedHttpException();
        $PostCat=posts_postcategory::where('post_fid','=',$id)->get()[0];
        $Post = $this->getNormalizedItem(posts_post::find($id)->toArray());
        $Post['category']=$PostCat->category_fid;
        $Post['categorycontent']=$this->getNormalizedItem(posts_category::find($PostCat->category_fid)->toArray());
        return response()->json(['Data'=>$Post], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('posts.post.delete'))
            throw new AccessDeniedHttpException();
        $Post = posts_post::find($id);
        $Post->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}