<?php
namespace App\models\posts;

use App\User;
use Illuminate\Database\Eloquent\Model;

class posts_postcategory extends Model
{
    protected $table = "posts_postcategory";
    protected $fillable = ['post_fid','category_fid'];
	public function post()
    {
        return $this->belongsTo(posts_post::class,'post_fid')->first();
    }
	public function category()
    {
        return $this->belongsTo(posts_category::class,'category_fid')->first();
    }
}