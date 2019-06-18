<?php
namespace App\Http\Controllers\posts\API;
use App\models\posts\posts_post;
use App\Http\Controllers\Controller;
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
        if($InputThumbnailflu!=null){
            $InputThumbnailflu->move('img/',$InputThumbnailflu->getClientOriginalName());
            $InputThumbnailflu='img/'.$InputThumbnailflu->getClientOriginalName();
        }
        else
        {
            $InputThumbnailflu='';
        }
        $Post = posts_post::create(['title'=>$InputTitle,'summary_te'=>$InputSummaryte,'content_te'=>$InputContentte,'thumbnail_flu'=>$InputThumbnailflu,'deletetime'=>-1]);
        return response()->json(['Data'=>$Post], 201);
    }
    public function update($id,Request $request)
    {
        if(!Bouncer::can('posts.post.edit'))
            throw new AccessDeniedHttpException();

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
        Bouncer::allow('admin')->to('posts.post.insert');
        Bouncer::allow('admin')->to('posts.post.edit');
        Bouncer::allow('admin')->to('posts.post.list');
        Bouncer::allow('admin')->to('posts.post.view');
        Bouncer::allow('admin')->to('posts.post.delete');
        //if(!Bouncer::can('posts.post.list'))
        //throw new AccessDeniedHttpException();
        $PostQuery = posts_post::where('id','>=','0');
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
        $Post = $this->getNormalizedItem(posts_post::find($id)->toArray());
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