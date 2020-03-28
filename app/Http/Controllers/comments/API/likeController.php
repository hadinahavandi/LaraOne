<?php
namespace App\Http\Controllers\comments\API;
use App\models\comments\comments_like;
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
use App\Http\Requests\comments\comments_likeAddRequest;
use App\Http\Requests\comments\comments_likeUpdateRequest;

class LikeController extends SweetController
{
    private $ModuleName='comments';

	public function changeState(comments_likeUpdateRequest $request)
    {
//        if(!Bouncer::can('comments.like.edit'))
//            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        $user=Auth::user()->getAuthIdentifier();
		$InputComment=$request->get('comment',-1);
        $IsAdded = comments_like::changeLikeState($user,$InputComment);
        return response()->json(['Data'=>$IsAdded?'1':'0'], 202);
    }
}