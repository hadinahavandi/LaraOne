<?php

namespace App\Http\Controllers\tts\web;

use App\models\Category;
use App\models\Context;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContextController extends Controller
{
    public function managelist()
    {
        $context=new Context();
        $context=$context->all();
        return view("context_list",["data"=>$context]);
    }
    public function manageload(Request $request)
    {
        $id=$request->get("id",-1);
        $context=null;
        if($id>0)
        {
            $context=new Context();
            $context=$context->find($id);
        }
        $cats=Category::all();
        return view("context_manage",["data"=>$context,"cats"=>$cats]);
    }
    public function delete(Request $request)
    {
        $id=$request->get("id",-1);
        if($id>0)
        {
            $context=new Context();
            $context=$context->find($id);
            $context->delete();
        }
        return redirect()->route('contextmanlist');
    }
    public function managesave(Request $request)
    {
        $id=$request->get("id",-1);
        $context=new Context();
        if($id>0)
            $context=$context->find($id);
        $context->title=$request->input("title");
        $context->category_fid=$request->input("category");
        $context->context=trim($request->input("context"));
        $context->summary="";
        $context->url=$request->input("url");
        $context->description=$request->input("description");

        if($context->url==null)
            $context->url="";
        if($context->description==null)
            $context->description="";
        if($context->summary==null)
            $context->summary="";
        $context->save();
        return redirect()->route('contextman', ['id' => $context->id]);
    }
}
