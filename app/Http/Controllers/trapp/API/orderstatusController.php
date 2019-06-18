<?php

namespace App\Http\Controllers\trapp\API;

use App\models\trapp\trapp_orderstatus;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class OrderstatusController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.orderstatus.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');

        $Orderstatus = trapp_orderstatus::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Orderstatus], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.orderstatus.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');;


        $Orderstatus = new trapp_orderstatus();
        $Orderstatus = $Orderstatus->find($id);
        $Orderstatus->name = $InputName;
        $Orderstatus->save();
        return response()->json(['Data' => $Orderstatus], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.orderstatus.insert');
        Bouncer::allow('admin')->to('trapp.orderstatus.edit');
        Bouncer::allow('admin')->to('trapp.orderstatus.list');
        Bouncer::allow('admin')->to('trapp.orderstatus.view');
        Bouncer::allow('admin')->to('trapp.orderstatus.delete');
        //if(!Bouncer::can('trapp.orderstatus.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $OrderstatusQuery = trapp_orderstatus::where('id', '>=', '0');
        $OrderstatusQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderstatusQuery, 'name', $SearchText);
        $OrderstatusQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderstatusQuery, 'name', $request->get('name'));
        $OrderstatusQuery = SweetQueryBuilder::OrderIfNotNull($OrderstatusQuery, 'name__sort', 'name', $request->get('name__sort'));
        $OrderstatussCount = $OrderstatusQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $OrderstatussCount], 200);
        $Orderstatuss = SweetQueryBuilder::setPaginationIfNotNull($OrderstatusQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $OrderstatussArray = [];
        for ($i = 0; $i < count($Orderstatuss); $i++) {
            $OrderstatussArray[$i] = $Orderstatuss[$i]->toArray();
        }
        $Orderstatus = $this->getNormalizedList($OrderstatussArray);
        return response()->json(['Data' => $Orderstatus, 'RecordCount' => $OrderstatussCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.orderstatus.view'))
        //throw new AccessDeniedHttpException();
        $Orderstatus = trapp_orderstatus::find($id);
        $OrderstatusObjectAsArray = $Orderstatus->toArray();
        $Orderstatus = $this->getNormalizedItem($OrderstatusObjectAsArray);
        return response()->json(['Data' => $Orderstatus], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.orderstatus.delete'))
            throw new AccessDeniedHttpException();
        $Orderstatus = trapp_orderstatus::find($id);
        $Orderstatus->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}