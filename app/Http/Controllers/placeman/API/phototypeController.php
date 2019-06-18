<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_phototype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PhototypeController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('placeman.phototype.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $Phototype = placeman_phototype::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Phototype], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('placeman.phototype.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
        $Phototype = new placeman_phototype();
        $Phototype = $Phototype->find($id);
        $Phototype->name = $InputName;
        $Phototype->save();
        return response()->json(['Data' => $Phototype], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.phototype.insert');
        Bouncer::allow('admin')->to('placeman.phototype.edit');
        Bouncer::allow('admin')->to('placeman.phototype.list');
        Bouncer::allow('admin')->to('placeman.phototype.view');
        Bouncer::allow('admin')->to('placeman.phototype.delete');
        //if(!Bouncer::can('placeman.phototype.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $PhototypeQuery = placeman_phototype::where('id', '>=', '0');
        $PhototypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($PhototypeQuery, 'name', $SearchText);
        $PhototypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($PhototypeQuery, 'name', $request->get('name'));
        $PhototypeQuery = SweetQueryBuilder::OrderIfNotNull($PhototypeQuery, 'name__sort', 'name', $request->get('name__sort'));
        $PhototypesCount = $PhototypeQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $PhototypesCount], 200);
        $Phototypes = SweetQueryBuilder::setPaginationIfNotNull($PhototypeQuery, $request->get('__startrow'), $request->get('__ esize'))->get();
        $PhototypesArray = [];
        for ($i = 0; $i < count($Phototypes); $i++) {
            $PhototypesArray[$i] = $Phototypes[$i]->toArray();
        }
        $Phototype = $this->getNormalizedList($PhototypesArray);
        return response()->json(['Data' => $Phototype, 'RecordCount' => $PhototypesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.phototype.view'))
        //throw new AccessDeniedHttpException();
        $Phototype = placeman_phototype::find($id);
        $PhototypeObjectAsArray = $Phototype->toArray();
        $Phototype = $this->getNormalizedItem($PhototypeObjectAsArray);
        return response()->json(['Data' => $Phototype], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.phototype.delete'))
            throw new AccessDeniedHttpException();
        $Phototype = placeman_phototype::find($id);
        $Phototype->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}