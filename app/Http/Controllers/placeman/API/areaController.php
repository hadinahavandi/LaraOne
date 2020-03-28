<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_area;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\placeman\placeman_areaAddRequest;
use App\Http\Requests\placeman\placeman_areaUpdateRequest;

class AreaController extends SweetController
{
    private $ModuleName = 'placeman';

    public function add(placeman_areaAddRequest $request)
    {
//        if(!Bouncer::can('placeman.area.insert'))
//            throw new AccessDeniedHttpException();
        $request->validated();

        $InputTitle = $request->input('title', ' ');
        $InputCity = $request->input('city', -1);

        $Area = placeman_area::create(['title' => $InputTitle, 'city_id' => $InputCity, 'deletetime' => -1]);
        return response()->json(['Data' => $Area], 201);
    }

    public function update($id, placeman_areaUpdateRequest $request)
    {
//        if (!Bouncer::can('placeman.area.edit'))
//            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputTitle = $request->get('title', ' ');
        $InputCity = $request->get('city', -1);;


        $Area = new placeman_area();
        $Area = $Area->find($id);
        $Area->title = $InputTitle;
        $Area->city_id = $InputCity;
        $Area->save();
        return response()->json(['Data' => $Area], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.area.insert');
        Bouncer::allow('admin')->to('placeman.area.edit');
        Bouncer::allow('admin')->to('placeman.area.list');
        Bouncer::allow('admin')->to('placeman.area.view');
        Bouncer::allow('admin')->to('placeman.area.delete');
        //if(!Bouncer::can('placeman.area.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $AreaQuery = placeman_area::where('id', '>=', '0');
        $AreaQuery = SweetQueryBuilder::WhereLikeIfNotNull($AreaQuery, 'title', $SearchText);
        $AreaQuery = SweetQueryBuilder::WhereLikeIfNotNull($AreaQuery, 'title', $request->get('title'));
        $AreaQuery = SweetQueryBuilder::OrderIfNotNull($AreaQuery, 'title__sort', 'title', $request->get('title__sort'));
        $AreaQuery = SweetQueryBuilder::WhereLikeIfNotNull($AreaQuery, 'city_id', $request->get('city'));
        $AreaQuery = SweetQueryBuilder::OrderIfNotNull($AreaQuery, 'city__sort', 'city_id', $request->get('city__sort'));
        $AreasCount = $AreaQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $AreasCount], 200);
        $Areas = SweetQueryBuilder::setPaginationIfNotNull($AreaQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $AreasArray = [];
        for ($i = 0; $i < count($Areas); $i++) {
            $AreasArray[$i] = $Areas[$i]->toArray();
            $CityField = $Areas[$i]->city();
            $AreasArray[$i]['citycontent'] = $CityField == null ? '' : $CityField->name;
        }
        $Area = $this->getNormalizedList($AreasArray);
        return response()->json(['Data' => $Area, 'RecordCount' => $AreasCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.area.view'))
        //throw new AccessDeniedHttpException();
        $Area = placeman_area::find($id);
        $AreaObjectAsArray = $Area->toArray();
        $CityObject = $Area->city();
        $CityObject = $CityObject == null ? '' : $CityObject;
        $AreaObjectAsArray['cityinfo'] = $this->getNormalizedItem($CityObject->toArray());
        $Area = $this->getNormalizedItem($AreaObjectAsArray);
        return response()->json(['Data' => $Area], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.area.delete'))
            throw new AccessDeniedHttpException();
        $Area = placeman_area::find($id);
        $Area->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}