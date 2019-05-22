<?php
namespace App\Http\Controllers\posts\Web;
use App\models\posts\posts_post;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostController extends SweetController
{

    public function list($page)
    {
        $PageSize=3;
        if($page<1)
            $page=1;
        $pageStart=($page-1)*$PageSize;

        $Post=new posts_post();
        $AllData=$Post->all()->count();
        $PageCount=$AllData/$PageSize;
//        if($AllData%$PageSize==0)
//            $PageCount++;
        $Posts=DB::table('posts_post')->skip($pageStart)->take($PageSize)->get();
        return view("posts/blogposts",["data"=>$Posts,"pageCount"=>$PageCount]);
    }

    public function index()
    {
        return $this->list(1);
    }
    public function get($id,Request $request)
    {
        $Post = posts_post::find($id);
        return view("posts/post",["dataItem"=>$Post]);
    }
}