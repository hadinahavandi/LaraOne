<?php

namespace App\Http\Controllers\trapp\API;

use App\models\trapp\trapp_owningtype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class OwningtypeController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.owningtype.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $Owningtype = trapp_owningtype::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Owningtype], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.owningtype.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
        $Owningtype = new trapp_owningtype();
        $Owningtype = $Owningtype->find($id);
        $Owningtype->name = $InputName;
        $Owningtype->save();
        return response()->json(['Data' => $Owningtype], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.owningtype.insert');
        Bouncer::allow('admin')->to('trapp.owningtype.edit');
        Bouncer::allow('admin')->to('trapp.owningtype.list');
        Bouncer::allow('admin')->to('trapp.owningtype.view');
        Bouncer::allow('admin')->to('trapp.owningtype.delete');
        //if(!Bouncer::can('trapp.owningtype.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $OwningtypeQuery = trapp_owningtype::where('id', '>=', '0');
        $OwningtypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($OwningtypeQuery, 'name', $SearchText);
        $OwningtypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($OwningtypeQuery, 'name', $request->get('name'));
        $OwningtypeQuery = SweetQueryBuilder::OrderIfNotNull($OwningtypeQuery, 'name__sort', 'name', $request->get('name__sort'));
        $OwningtypesCount = $OwningtypeQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $OwningtypesCount], 200);
        $Owningtypes = SweetQueryBuilder::setPaginationIfNotNull($OwningtypeQuery, $request->get('__startrow'), $request->get('__ esize'))->get();
        $OwningtypesArray = [];
        for ($i = 0; $i < count($Owningtypes); $i++) {
            $OwningtypesArray[$i] = $Owningtypes[$i]->toArray();
        }
        $Owningtype = $this->getNormalizedList($OwningtypesArray);
        return response()->json(['Data' => $Owningtype, 'RecordCount' => $OwningtypesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.owningtype.view'))
        //throw new AccessDeniedHttpException();
        $Owningtype = trapp_owningtype::find($id);
        $OwningtypeObjectAsArray = $Owningtype->toArray();
        $Owningtype = $this->getNormalizedItem($OwningtypeObjectAsArray);
        return response()->json(['Data' => $Owningtype], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.owningtype.delete'))
            throw new AccessDeniedHttpException();
        $Owningtype = trapp_owningtype::find($id);
        $Owningtype->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}