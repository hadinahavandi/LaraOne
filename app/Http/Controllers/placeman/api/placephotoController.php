<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_placephoto;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PlacephotoController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('placeman.placephoto.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $InputPhotoigu = $request->file('photoigu');
        if ($InputPhotoigu != null) {
            $InputPhotoigu->move('img/placeman/placephoto', $InputPhotoigu->getClientOriginalName());
            $InputPhotoigu = 'img/placeman/placephoto/' . $InputPhotoigu->getClientOriginalName();
        } else {
            $InputPhotoigu = '';
        }
        $InputPhototype = $request->input('phototype');
        $InputPlace = $request->input('place');
        $Placephoto = placeman_placephoto::create(['name' => $InputName, 'photo_igu' => $InputPhotoigu, 'phototype_fid' => $InputPhototype, 'place_fid' => $InputPlace, 'deletetime' => -1]);
        return response()->json(['Data' => $Placephoto], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('placeman.placephoto.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
        $InputPhotoigu = $request->file('photoigu');
        if ($InputPhotoigu != null) {
            $InputPhotoigu->move('img/', $InputPhotoigu->getClientOriginalName());
            $InputPhotoigu = 'img/' . $InputPhotoigu->getClientOriginalName();
        } else {
            $InputPhotoigu = '';
        }
        $InputPhototype = $request->get('phototype');
        $InputPlace = $request->get('place');
        $Placephoto = new placeman_placephoto();
        $Placephoto = $Placephoto->find($id);
        $Placephoto->name = $InputName;
        if ($InputPhotoigu != null)
            $Placephoto->photo_igu = $InputPhotoigu;
        $Placephoto->phototype_fid = $InputPhototype;
        $Placephoto->place_fid = $InputPlace;
        $Placephoto->save();
        return response()->json(['Data' => $Placephoto], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.placephoto.insert');
        Bouncer::allow('admin')->to('placeman.placephoto.edit');
        Bouncer::allow('admin')->to('placeman.placephoto.list');
        Bouncer::allow('admin')->to('placeman.placephoto.view');
        Bouncer::allow('admin')->to('placeman.placephoto.delete');
        //if(!Bouncer::can('placeman.placephoto.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $PlacephotoQuery = placeman_placephoto::where('id', '>=', '0');
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'name', $SearchText);
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'name', $request->get('name'));
        $PlacephotoQuery = SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery, 'name__sort', 'name', $request->get('name__sort'));
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'phototype_fid', $request->get('phototype'));
        $PlacephotoQuery = SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery, 'phototype__sort', 'phototype_fid', $request->get('phototype__sort'));
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'place_fid', $request->get('place'));
        $PlacephotoQuery = SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery, 'place__sort', 'place_fid', $request->get('place__sort'));
        $PlacephotosCount = $PlacephotoQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $PlacephotosCount], 200);
        $Placephotos = SweetQueryBuilder::setPaginationIfNotNull($PlacephotoQuery, $request->get('__startrow'), $request->get('__ esize'))->get();
        $PlacephotosArray = [];
        for ($i = 0; $i < count($Placephotos); $i++) {
            $PlacephotosArray[$i] = $Placephotos[$i]->toArray();
            $PhototypeField = $Placephotos[$i]->phototype();
            $PlacephotosArray[$i]['phototypecontent'] = $PhototypeField == null ? '' : $PhototypeField->name;
            $PlaceField = $Placephotos[$i]->place();
            $PlacephotosArray[$i]['placecontent'] = $PlaceField == null ? '' : $PlaceField->name;
        }
        $Placephoto = $this->getNormalizedList($PlacephotosArray);
        return response()->json(['Data' => $Placephoto, 'RecordCount' => $PlacephotosCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.placephoto.view'))
        //throw new AccessDeniedHttpException();
        $Placephoto = placeman_placephoto::find($id);
        $PlacephotoObjectAsArray = $Placephoto->toArray();
        $PhototypeID = $Placephoto->phototype_fid;
        $PhototypeObject = $PhototypeID > 0 ? placeman_phototype::find($PhototypeID) : '';
        $PlacephotoObjectAsArray['phototypeinfo'] = $this->getNormalizedItem($PhototypeObject->toArray());
        $PlaceID = $Placephoto->place_fid;
        $PlaceObject = $PlaceID > 0 ? placeman_place::find($PlaceID) : '';
        $PlacephotoObjectAsArray['placeinfo'] = $this->getNormalizedItem($PlaceObject->toArray());
        $Placephoto = $this->getNormalizedItem($PlacephotoObjectAsArray);
        return response()->json(['Data' => $Placephoto], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.placephoto.delete'))
            throw new AccessDeniedHttpException();
        $Placephoto = placeman_placephoto::find($id);
        $Placephoto->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}