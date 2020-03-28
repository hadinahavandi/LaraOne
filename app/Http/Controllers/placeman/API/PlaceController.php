<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_place;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use App\User;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PlaceController extends SweetController
{

    public function add(Request $request)
    {
//        if (!Bouncer::can('placeman.place.insert'))
//            throw new AccessDeniedHttpException();

        $InputTitle = $request->input('title');
        $InputTitle = $InputTitle != null ? $InputTitle : "";
        $InputLogoigu = $request->file('logoigu');
        if ($InputLogoigu != null) {
            $InputLogoigu->move('img/placeman/place', $InputLogoigu->getClientOriginalName());
            $InputLogoigu = 'img/placeman/place/' . $InputLogoigu->getClientOriginalName();
        } else {
            $InputLogoigu = '';
        }
        $InputDescription = $request->input('description');
        $InputDescription = $InputDescription != null ? $InputDescription : "";
        $InputActive = "0";
        $InputAddress = $request->input('address');
        $InputArea = $request->input('area');
        $InputUser = Auth::user()->getAuthIdentifier();
        $InputLatitude = $request->input('latitude');
        $InputLongitude = $request->input('longitude');
        $InputVisits = "0";

        $Place = placeman_place::create(['title' => $InputTitle, 'logo_igu' => $InputLogoigu, 'description' => $InputDescription, 'isactive' => $InputActive, 'address' => $InputAddress, 'area_fid' => $InputArea, 'user_fid' => $InputUser, 'latitude' => $InputLatitude, 'longitude' => $InputLongitude, 'visits' => $InputVisits, 'deletetime' => -1]);
        return response()->json(['Data' => $Place], 201);
    }

    public function update($id, Request $request)
    {
//        if (!Bouncer::can('placeman.place.edit'))
//            throw new AccessDeniedHttpException();

        $InputTitle = $request->get('title');
        $InputLogoigu = $request->file('logoigu');
        if ($InputLogoigu != null) {
            $InputLogoigu->move('img/', $InputLogoigu->getClientOriginalName());
            $InputLogoigu = 'img/' . $InputLogoigu->getClientOriginalName();
        } else {
            $InputLogoigu = '';
        }
        $InputDescription = $request->get('description');
        $InputActive = $request->get('active');
        $InputAddress = $request->get('address');
        $InputArea = $request->get('area');
//        $InputUser = $request->get('user');
        $InputLatitude = $request->get('latitude');
        $InputLongitude = $request->get('longitude');
//        $InputVisits = $request->get('visits');;


        $Place = new placeman_place();
        $Place = $Place->find($id);
        $Place->title = $InputTitle;
        if ($InputLogoigu != null)
            $Place->logo_igu = $InputLogoigu;
        $Place->description = $InputDescription;
        $Place->isactive = $InputActive;
        $Place->address = $InputAddress;
        if($InputArea>0)
            $Place->area_fid = $InputArea;
//        $Place->user_fid = $InputUser;
        $Place->latitude = $InputLatitude;
        $Place->longitude = $InputLongitude;
//        $Place->visits = $InputVisits;
        $Place->save();
        return response()->json(['Data' => $Place], 202);
    }

    public function activate($id, $type, Request $request)
    {
        if (!Bouncer::can('placeman.place.edit'))
            throw new AccessDeniedHttpException();

        $Place = new placeman_place();
        $Place = $Place->find($id);
        if ($type == 1) {
            $Place->isactive = '1';
        } else
            $Place->isactive = '0';
        $Place->save();
        return response()->json(['Data' => $Place], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('placeman.place.insert');
        Bouncer::allow('admin')->to('placeman.place.edit');
        Bouncer::allow('admin')->to('placeman.place.list');
        Bouncer::allow('admin')->to('placeman.place.view');
        Bouncer::allow('admin')->to('placeman.place.delete');
        //if(!Bouncer::can('placeman.place.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $PlaceQuery = placeman_place::where('id', '>=', '0');
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'title', $SearchText);
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'title', $request->get('title'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'title__sort', 'title', $request->get('title__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'description', $request->get('description'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'description__sort', 'description', $request->get('description__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'isactive', $request->get('active'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'active__sort', 'isactive', $request->get('active__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'address', $request->get('address'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'address__sort', 'address', $request->get('address__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'area_fid', $request->get('area'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'area__sort', 'area_fid', $request->get('area__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'user_fid', $request->get('user'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'user__sort', 'user_fid', $request->get('user__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'latitude', $request->get('latitude'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'latitude__sort', 'latitude', $request->get('latitude__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'longitude', $request->get('longitude'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'longitude__sort', 'longitude', $request->get('longitude__sort'));
        $PlaceQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlaceQuery, 'visits', $request->get('visits'));
        $PlaceQuery = SweetQueryBuilder::OrderIfNotNull($PlaceQuery, 'visits__sort', 'visits', $request->get('visits__sort'));
        $PlacesCount = $PlaceQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $PlacesCount], 200);
        $Places = SweetQueryBuilder::setPaginationIfNotNull($PlaceQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $PlacesArray = [];
        for ($i = 0; $i < count($Places); $i++) {
            $PlacesArray[$i] = $Places[$i]->toArray();
            $AreaField = $Places[$i]->area();
            $CityField = $AreaField == null ? '' : $AreaField->city();
            $ProvinceField = $CityField == null ? '' : $CityField->province();
            $PlacesArray[$i]['areacontent'] = $AreaField == null ? '' : $AreaField->title;
            $PlacesArray[$i]['citycontent'] = $CityField == null ? '' : $CityField->title;
            $PlacesArray[$i]['provincecontent'] = $ProvinceField == null ? '' : $ProvinceField->title;
            $UserField = $Places[$i]->user();
            $PlacesArray[$i]['usercontent'] = $UserField == null ? '' : $UserField->name;
        }
        $Place = $this->getNormalizedList($PlacesArray);
        return response()->json(['Data' => $Place, 'RecordCount' => $PlacesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('placeman.place.view'))
        //throw new AccessDeniedHttpException();
        $Place = placeman_place::find($id);
        $PlaceObjectAsArray = $Place->toArray();
        $AreaField = $Place->area();
        $CityField = $AreaField == null ? '' : $AreaField->city();
        $ProvinceField = $CityField == null ? '' : $CityField->province();
        $PlaceObjectAsArray['areainfo'] = $AreaField == null ? '' : $AreaField;
        $PlaceObjectAsArray['cityinfo'] = $CityField == null ? '' : $CityField;
        $PlaceObjectAsArray['provinceinfo'] = $ProvinceField == null ? '' : $ProvinceField;
        $UserID = $Place->user_fid;
        $UserObject = $UserID > 0 ? User::find($UserID) : '';
        $PlaceObjectAsArray['userinfo'] = $this->getNormalizedItem($UserObject->toArray());
        $Place = $this->getNormalizedItem($PlaceObjectAsArray);
        return response()->json(['Data' => $Place], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('placeman.place.delete'))
            throw new AccessDeniedHttpException();
        $Place = placeman_place::find($id);
        $Place->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}