<?php
namespace App\models\comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class comments_like extends Model
{
    protected $table = "comments_like";
    protected $fillable = ['comment_fid','user_fid'];
	public function comment()
    {
        return $this->belongsTo(comments_comment::class,'comment_fid')->first();
    }
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }

    /**
     * @param $userId
     * @param $commentId
     * @return bool isLiked
     */
    public static function changeLikeState($userId, $commentId){
        $like=comments_like::where('comment_fid','=',$commentId)->where('user_fid','=',$userId)->first();
        if($like==null || $like->id<=0) {
            $like = new comments_like();
            $like->user_fid = $userId;
            $like->comment_fid = $commentId;
            $like->save();
            return true;
        }
        else {
            $like->delete();
            return false;
        }
    }
}