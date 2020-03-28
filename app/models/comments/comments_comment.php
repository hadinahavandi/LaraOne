<?php
namespace App\models\comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class comments_comment extends Model
{
    protected $table = "comments_comment";
    protected $fillable = ['text','commenttype_fid','publish_time','rate_num','tempuser_fid','mother_comment_fid','user_fid','subjectentity_fid'];
	public function commenttype()
    {
        return $this->belongsTo(comments_commenttype::class,'commenttype_fid')->first();
    }
	public function tempuser()
    {
        return $this->belongsTo(User::class,'tempuser_fid')->first();
    }
	public function mothercomment()
    {
        return $this->belongsTo(mother_comment::class,'mother_comment_fid')->first();
    }
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
    public function likes()
    {
        return comments_like::where('comment_fid','=',$this->id)->get()->count();
    }
	public function subjectentity()
    {
        return $this->belongsTo(comments_subjectentity::class,'subjectentity_fid')->first();
    }
}