<?php

namespace App\Http\Controllers\tts\api;

use App\models\Category;
use App\models\Context;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContextController extends Controller
{
    public function list()
    {
        return response()->json(Context::all(["id","title"]), 200);
    }
    public function one($id)
    {
        $context=null;
        if($id>0)
        {
            $context=new Context();
            $context=$context->find($id);
            if($context!=null)
            return response()->json($context, 200);
        }
        return response()->json([], 200);
    }
}
