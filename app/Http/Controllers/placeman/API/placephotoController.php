<?php
namespace App\Http\Controllers\placeman\API;

use App\Http\Requests\placeman\placephoto\placeman_placephotoAddRequest;
use App\Http\Requests\placeman\placephoto\placeman_placephotoUpdateRequest;
use App\models\placeman\placeman_place;
use App\models\placeman\placeman_placephoto;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PlacephotoController extends SweetController
{
    private $ModuleName = 'placeman';

    private function getUserPlaces()
    {

        $user = Auth::user();
        $UserPlaces = placeman_place::where('user_fid', '=', $user->id)->get();
        return $UserPlaces;
    }
    public function add(placeman_placephotoAddRequest $request)
    {
//        if(!Bouncer::can('placeman.placephoto.insert'))
//            throw new AccessDeniedHttpException();


        $request->validated();
        $InputName = $request->getName();
        $InputPhototype = 1;
        $InputPlace =$request->getPlace();
        if($InputPlace<=0)
            $InputPlace=$this->getUserPlaces()[0]->id;

        $Placephoto = placeman_placephoto::create(['name' => $InputName, 'phototype_fid' => $InputPhototype, 'place_fid' => $InputPlace, 'deletetime' => -1]);
        $InputPhotoiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'placephoto', 'photoigu', $Placephoto->id, 'jpg');
        $Placephoto->photo_igu = $InputPhotoiguPath->uploadFromRequest($request->getPhotoigu());
        $InputPhotoiguPath->compressImage(75, 600, 600);
        $InputPhotoiguPath->compressImage(75, 200, 200, $Placephoto->photo_igu . "thumb");

        $Placephoto->save();
        return response()->json(['Data' => $Placephoto], 201);
    }

    public function update($id, placeman_placephotoUpdateRequest $request)
    {
//        if(!Bouncer::can('placeman.placephoto.edit'))
//            throw new AccessDeniedHttpException();

//        $InputName = $request->get('name');
//		$InputPhototype=$request->get('phototype');
//		$InputPlace=$request->get('place');;


        $request->validated();
        $Placephoto = new placeman_placephoto();
        $Placephoto = $Placephoto->find($id);
//        $Placephoto->name = $InputName;
//        $Placephoto->phototype_fid=$InputPhototype;
//        $Placephoto->place_fid=$InputPlace;
        $InputPhotoiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'placephoto', 'photoigu', $Placephoto->id, 'jpg');
        if ($InputPhotoiguPath != null) {
            $Placephoto->photo_igu = $InputPhotoiguPath->uploadFromRequest($request->getPhotoigu());
            $InputPhotoiguPath->compressImage(75, 1280, 720);
            $InputPhotoiguPath->compressImage(75, 200, 200, $Placephoto->photo_igu . "thumb");

        }
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
        $Placephotos = SweetQueryBuilder::setPaginationIfNotNull($PlacephotoQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
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

    public function listPlacePhotos($PlaceID, Request $request)
    {
        $SearchText = $request->get('searchtext');
        $PlacephotoQuery = placeman_placephoto::where('id', '>=', '0');
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'name', $SearchText);
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'name', $request->get('name'));
        $PlacephotoQuery = SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery, 'name__sort', 'name', $request->get('name__sort'));
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'phototype_fid', $request->get('phototype'));
        $PlacephotoQuery = SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery, 'phototype__sort', 'phototype_fid', $request->get('phototype__sort'));
        $PlacephotoQuery = SweetQueryBuilder::WhereLikeIfNotNull($PlacephotoQuery, 'place_fid', $PlaceID);
//        $PlacephotoQuery =SweetQueryBuilder::OrderIfNotNull($PlacephotoQuery,'place__sort','place_fid',$request->get('place__sort'));
        $PlacephotosCount = $PlacephotoQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $PlacephotosCount], 200);
        $Placephotos = SweetQueryBuilder::setPaginationIfNotNull($PlacephotoQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
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
        $PhototypeObject = $Placephoto->phototype();
        $PhototypeObject = $PhototypeObject == null ? '' : $PhototypeObject;
        $PlacephotoObjectAsArray['phototypeinfo'] = $this->getNormalizedItem($PhototypeObject->toArray());
        $PlaceObject = $Placephoto->place();
        $PlaceObject = $PlaceObject == null ? '' : $PlaceObject;
        $PlacephotoObjectAsArray['placeinfo'] = $this->getNormalizedItem($PlaceObject->toArray());
        $area = $PlaceObject->area();
        $city = $area->city();
        $province = $city->province();
        $PlacephotoObjectAsArray['placeinfo']['areainfo'] = $this->getNormalizedItem($area->toArray());
        $PlacephotoObjectAsArray['placeinfo']['cityinfo'] = $this->getNormalizedItem($city->toArray());
        $PlacephotoObjectAsArray['placeinfo']['provinceinfo'] = $this->getNormalizedItem($province->toArray());
        $Placephoto = $this->getNormalizedItem($PlacephotoObjectAsArray);
        return response()->json(['Data' => $Placephoto], 200);
    }

    public function delete($id, Request $request)
    {
//        if(!Bouncer::can('placeman.placephoto.delete'))
//            throw new AccessDeniedHttpException();
        $Placephoto = placeman_placephoto::find($id);
        $Placephoto->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}