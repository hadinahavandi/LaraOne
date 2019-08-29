<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_area;
use App\models\placeman\placeman_city;
use App\models\placeman\placeman_province;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\placeman\placeman_provinceAddRequest;
use App\Http\Requests\placeman\placeman_provinceUpdateRequest;

class ProvinceController extends SweetController
{
    private $ModuleName = 'placeman';

    public function add(placeman_provinceAddRequest $request)
    {
        if (!Bouncer::can('placeman.province.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();

        $InputTitle = $request->input('title', ' ');

        $Province = placeman_province::create(['title' => $InputTitle, 'deletetime' => -1]);
        return response()->json(['Data' => $Province], 201);
    }

    public function update($id, placeman_provinceUpdateRequest $request)
    {
        if (!Bouncer::can('placeman.province.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputTitle = $request->get('title', ' ');;


        $Province = new placeman_province();
        $Province = $Province->find($id);
        $Province->title = $InputTitle;
        $Province->save();
        return response()->json(['Data' => $Province], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.province.insert');
        Bouncer::allow('admin')->to('placeman.province.edit');
        Bouncer::allow('admin')->to('placeman.province.list');
        Bouncer::allow('admin')->to('placeman.province.view');
        Bouncer::allow('admin')->to('placeman.province.delete');
        //if(!Bouncer::can('placeman.province.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $ProvinceQuery = placeman_province::where('id', '>=', '0');
        $ProvinceQuery = SweetQueryBuilder::WhereLikeIfNotNull($ProvinceQuery, 'title', $SearchText);
        $ProvinceQuery = SweetQueryBuilder::WhereLikeIfNotNull($ProvinceQuery, 'title', $request->get('title'));
        $ProvinceQuery = SweetQueryBuilder::OrderIfNotNull($ProvinceQuery, 'title__sort', 'title', $request->get('title__sort'));
        $ProvincesCount = $ProvinceQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $ProvincesCount], 200);
        $Provinces = SweetQueryBuilder::setPaginationIfNotNull($ProvinceQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $ProvincesArray = [];
        for ($i = 0; $i < count($Provinces); $i++) {
            $ProvincesArray[$i] = $Provinces[$i]->toArray();
            $Cities = placeman_city::where('province_id', '=', $Provinces[$i]->id)->get();
            $CitiesArray = [];
            for ($ci = 0; $ci < count($Cities); $ci++) {
                $CitiesArray[$ci] = $Cities[$ci]->toArray();
                $Areas = placeman_area::where('city_id', '=', $Cities[$ci]->id)->get();
                $CitiesArray[$ci]['areas'] = $this->getNormalizedList($Areas->toArray(), ['created_at', 'updated_at', 'city_id']);
            }
            $ProvincesArray[$i]['cities'] = $this->getNormalizedList($CitiesArray, ['created_at', 'updated_at', 'province_id']);
        }
        $Province = $this->getNormalizedList($ProvincesArray, ['created_at', 'updated_at']);
        return response()->json(['Data' => $Province, 'RecordCount' => $ProvincesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.province.view'))
        //throw new AccessDeniedHttpException();
        $Province = placeman_province::find($id);
        $ProvinceObjectAsArray = $Province->toArray();
        $Province = $this->getNormalizedItem($ProvinceObjectAsArray);
        return response()->json(['Data' => $Province], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.province.delete'))
            throw new AccessDeniedHttpException();
        $Province = placeman_province::find($id);
        $Province->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}