<?php

namespace App\Http\Controllers\tts\web;

use App\models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function load(Request $request)
    {

    }
    public function managelist()
    {
        $cat=new Category();
        $cat=$cat->all();
        return view("category_list",["data"=>$cat]);
    }
    public function manageload(Request $request)
    {
        $id=$request->get("id",-1);
        $cat=null;
        if($id>0)
        {
            $cat=new Category();
            $cat=$cat->find($id);
        }
        return view("category_manage",["data"=>$cat]);
    }
    public function delete(Request $request)
    {
        $id=$request->get("id",-1);
        if($id>0)
        {
            $cat=new Category();
            $cat=$cat->find($id);
            $cat->delete();
        }
        return redirect()->route('catmanlist');
    }
    public function managesave(Request $request)
    {
        $id=$request->get("id",-1);
        $cat=new Category();
        if($id>0)
            $cat=$cat->find($id);
        $cat->title=$request->input("title");
        $cat->save();
        return redirect()->route('catman', ['id' => $cat->id]);
    }
}
