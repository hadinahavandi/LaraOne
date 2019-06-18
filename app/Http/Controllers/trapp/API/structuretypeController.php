<?php

namespace App\Http\Controllers\trapp\API;

use App\models\trapp\trapp_structuretype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StructuretypeController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.structuretype.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $Structuretype = trapp_structuretype::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Structuretype], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.structuretype.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
        $Structuretype = new trapp_structuretype();
        $Structuretype = $Structuretype->find($id);
        $Structuretype->name = $InputName;
        $Structuretype->save();
        return response()->json(['Data' => $Structuretype], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.structuretype.insert');
        Bouncer::allow('admin')->to('trapp.structuretype.edit');
        Bouncer::allow('admin')->to('trapp.structuretype.list');
        Bouncer::allow('admin')->to('trapp.structuretype.view');
        Bouncer::allow('admin')->to('trapp.structuretype.delete');
        //if(!Bouncer::can('trapp.structuretype.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $StructuretypeQuery = trapp_structuretype::where('id', '>=', '0');
        $StructuretypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($StructuretypeQuery, 'name', $SearchText);
        $StructuretypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($StructuretypeQuery, 'name', $request->get('name'));
        $StructuretypeQuery = SweetQueryBuilder::OrderIfNotNull($StructuretypeQuery, 'name__sort', 'name', $request->get('name__sort'));
        $StructuretypesCount = $StructuretypeQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $StructuretypesCount], 200);
        $Structuretypes = SweetQueryBuilder::setPaginationIfNotNull($StructuretypeQuery, $request->get('__startrow'), $request->get('__ esize'))->get();
        $StructuretypesArray = [];
        for ($i = 0; $i < count($Structuretypes); $i++) {
            $StructuretypesArray[$i] = $Structuretypes[$i]->toArray();
        }
        $Structuretype = $this->getNormalizedList($StructuretypesArray);
        return response()->json(['Data' => $Structuretype, 'RecordCount' => $StructuretypesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.structuretype.view'))
        //throw new AccessDeniedHttpException();
        $Structuretype = trapp_structuretype::find($id);
        $StructuretypeObjectAsArray = $Structuretype->toArray();
        $Structuretype = $this->getNormalizedItem($StructuretypeObjectAsArray);
        return response()->json(['Data' => $Structuretype], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.structuretype.delete'))
            throw new AccessDeniedHttpException();
        $Structuretype = trapp_structuretype::find($id);
        $Structuretype->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}