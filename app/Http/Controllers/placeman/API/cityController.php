<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_city;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\placeman\placeman_cityAddRequest;
use App\Http\Requests\placeman\placeman_cityUpdateRequest;

class CityController extends SweetController
{
    private $ModuleName = 'placeman';

    public function add(placeman_cityAddRequest $request)
    {
//        if(!Bouncer::can('placeman.city.insert'))
//            throw new AccessDeniedHttpException();
        $request->validated();

        $InputTitle = $request->input('title', ' ');
        $InputProvince = $request->input('province', -1);

        $City = placeman_city::create(['title' => $InputTitle, 'province_id' => $InputProvince, 'deletetime' => -1]);
        return response()->json(['Data' => $City], 201);
    }

    public function update($id, placeman_cityUpdateRequest $request)
    {
//        if (!Bouncer::can('placeman.city.edit'))
//            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputTitle = $request->get('title', ' ');
        $InputProvince = $request->get('province', -1);;


        $City = new placeman_city();
        $City = $City->find($id);
        $City->title = $InputTitle;
        $City->province_id = $InputProvince;
        $City->save();
        return response()->json(['Data' => $City], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.city.insert');
        Bouncer::allow('admin')->to('placeman.city.edit');
        Bouncer::allow('admin')->to('placeman.city.list');
        Bouncer::allow('admin')->to('placeman.city.view');
        Bouncer::allow('admin')->to('placeman.city.delete');
        //if(!Bouncer::can('placeman.city.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $CityQuery = placeman_city::where('id', '>=', '0');
        $CityQuery = SweetQueryBuilder::WhereLikeIfNotNull($CityQuery, 'title', $SearchText);
        $CityQuery = SweetQueryBuilder::WhereLikeIfNotNull($CityQuery, 'title', $request->get('title'));
        $CityQuery = SweetQueryBuilder::OrderIfNotNull($CityQuery, 'title__sort', 'title', $request->get('title__sort'));
        $CityQuery = SweetQueryBuilder::WhereLikeIfNotNull($CityQuery, 'province_id', $request->get('province'));
        $CityQuery = SweetQueryBuilder::OrderIfNotNull($CityQuery, 'province__sort', 'province_id', $request->get('province__sort'));
        $CitysCount = $CityQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $CitysCount], 200);
        $Citys = SweetQueryBuilder::setPaginationIfNotNull($CityQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $CitysArray = [];
        for ($i = 0; $i < count($Citys); $i++) {
            $CitysArray[$i] = $Citys[$i]->toArray();
            $ProvinceField = $Citys[$i]->province();
            $CitysArray[$i]['provincecontent'] = $ProvinceField == null ? '' : $ProvinceField->name;
        }
        $City = $this->getNormalizedList($CitysArray);
        return response()->json(['Data' => $City, 'RecordCount' => $CitysCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.city.view'))
        //throw new AccessDeniedHttpException();
        $City = placeman_city::find($id);
        $CityObjectAsArray = $City->toArray();
        $ProvinceObject = $City->province();
        $ProvinceObject = $ProvinceObject == null ? '' : $ProvinceObject;
        $CityObjectAsArray['provinceinfo'] = $this->getNormalizedItem($ProvinceObject->toArray());
        $City = $this->getNormalizedItem($CityObjectAsArray);
        return response()->json(['Data' => $City], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.city.delete'))
            throw new AccessDeniedHttpException();
        $City = placeman_city::find($id);
        $City->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}