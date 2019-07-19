<?php
namespace App\Http\Controllers\trapp\API;
use App\models\trapp\trapp_villaowner;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VillaownerController extends SweetController
{
    private $ModuleName = 'trapp';

    public function add(Request $request)
    {
//        if(!Bouncer::can('trapp.villaowner.insert'))
//            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $InputUser = Auth::user()->id;
        $InputNationalcodebnum = $request->input('nationalcodebnum');
        $InputAddress = $request->input('address');
        $InputShabacodebnum = $request->input('shabacodebnum');
        $InputTelbnum = $request->input('telbnum');
        $InputBackuptelbnum = $request->input('backuptelbnum');
        $InputEmail = $request->input('email');
        $InputBackupmobilebnum = $request->input('backupmobilebnum');
        $InputPlacemanarea = $request->input('placemanarea');

        $Villaowner = trapp_villaowner::create(['name' => $InputName, 'user_fid' => $InputUser, 'nationalcode_bnum' => $InputNationalcodebnum, 'address' => $InputAddress, 'shabacode_bnum' => $InputShabacodebnum, 'tel_bnum' => $InputTelbnum, 'backuptel_bnum' => $InputBackuptelbnum, 'email' => $InputEmail, 'backupmobile_bnum' => $InputBackupmobilebnum, 'placeman_area_fid' => $InputPlacemanarea, 'deletetime' => -1]);
        $InputPhotoiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'villaowner', 'photoigu', $Villaowner->id, 'jpg');
        $InputNationalcardiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'villaowner', 'nationalcardigu', $Villaowner->id, 'jpg');
        $Villaowner->photo_igu = $InputPhotoiguPath->uploadFromRequest($request->file('photoigu'));
        $Villaowner->nationalcard_igu = $InputNationalcardiguPath->uploadFromRequest($request->file('nationalcardigu'));
        $Villaowner->save();
        return response()->json(['Data' => $Villaowner], 201);
    }

    public function update($id, Request $request)
    {
//        if(!Bouncer::can('trapp.villaowner.edit'))
//            throw new AccessDeniedHttpException();
//
        $InputName = $request->get('name');
        $InputNationalcodebnum = $request->get('nationalcodebnum');
        $InputAddress = $request->get('address');
        $InputShabacodebnum = $request->get('shabacodebnum');
        $InputTelbnum = $request->get('telbnum');
        $InputBackuptelbnum = $request->get('backuptelbnum');
        $InputEmail = $request->get('email');
        $InputBackupmobilebnum = $request->get('backupmobilebnum');
        $InputPlacemanarea = $request->get('placemanarea');;
            
    
        $Villaowner = new trapp_villaowner();
        $Villaowner = $Villaowner->find($id);
        $Villaowner->name = $InputName;
        $Villaowner->nationalcode_bnum = $InputNationalcodebnum;
        $Villaowner->address = $InputAddress;
        $Villaowner->shabacode_bnum = $InputShabacodebnum;
        $Villaowner->tel_bnum = $InputTelbnum;
        $Villaowner->backuptel_bnum = $InputBackuptelbnum;
        $Villaowner->email = $InputEmail;
        $Villaowner->backupmobile_bnum = $InputBackupmobilebnum;
        $Villaowner->placeman_area_fid = $InputPlacemanarea;
        $InputPhotoiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'villaowner', 'photoigu', $Villaowner->id, 'jpg');
        $InputNationalcardiguPath = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'villaowner', 'nationalcardigu', $Villaowner->id, 'jpg');
        if ($InputPhotoiguPath != null)
            $Villaowner->photo_igu = $InputPhotoiguPath->uploadFromRequest($request->file('photoigu'));
        if ($InputNationalcardiguPath != null)
            $Villaowner->nationalcard_igu = $InputNationalcardiguPath->uploadFromRequest($request->file('nationalcardigu'));
        $Villaowner->save();
        return response()->json(['Data' => $Villaowner], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.villaowner.insert');
        Bouncer::allow('admin')->to('trapp.villaowner.edit');
        Bouncer::allow('admin')->to('trapp.villaowner.list');
        Bouncer::allow('admin')->to('trapp.villaowner.view');
        Bouncer::allow('admin')->to('trapp.villaowner.delete');
        //if(!Bouncer::can('trapp.villaowner.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $VillaownerQuery = trapp_villaowner::where('id', '>=', '0');
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'name', $SearchText);
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'name', $request->get('name'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'name__sort', 'name', $request->get('name__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'user_fid', $request->get('user'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'user__sort', 'user_fid', $request->get('user__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'nationalcode_bnum', $request->get('nationalcodebnum'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'nationalcodebnum__sort', 'nationalcode_bnum', $request->get('nationalcodebnum__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'address', $request->get('address'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'address__sort', 'address', $request->get('address__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'shabacode_bnum', $request->get('shabacodebnum'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'shabacodebnum__sort', 'shabacode_bnum', $request->get('shabacodebnum__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'tel_bnum', $request->get('telbnum'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'telbnum__sort', 'tel_bnum', $request->get('telbnum__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'backuptel_bnum', $request->get('backuptelbnum'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'backuptelbnum__sort', 'backuptel_bnum', $request->get('backuptelbnum__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'email', $request->get('email'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'email__sort', 'email', $request->get('email__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'backupmobile_bnum', $request->get('backupmobilebnum'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'backupmobilebnum__sort', 'backupmobile_bnum', $request->get('backupmobilebnum__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'placeman_area_fid', $request->get('placemanarea'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'placemanarea__sort', 'placeman_area_fid', $request->get('placemanarea__sort'));
        $VillaownersCount = $VillaownerQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $VillaownersCount], 200);
        $Villaowners = SweetQueryBuilder::setPaginationIfNotNull($VillaownerQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $VillaownersArray = [];
        for ($i = 0; $i < count($Villaowners); $i++) {
            $VillaownersArray[$i] = $Villaowners[$i]->toArray();
            $UserField = $Villaowners[$i]->user();
            $VillaownersArray[$i]['usercontent'] = $UserField == null ? '' : $UserField->name;
            $AreaField = $Villaowners[$i]->placemanarea();
            $CityField = $AreaField == null ? '' : $AreaField->city();
            $ProvinceField = $CityField == null ? '' : $CityField->province();
            $VillaownersArray[$i]['placemanareacontent'] = $AreaField == null ? '' : $AreaField->title;
            $VillaownersArray[$i]['citycontent'] = $CityField == null ? '' : $CityField->title;
            $VillaownersArray[$i]['provincecontent'] = $ProvinceField == null ? '' : $ProvinceField->title;
        }
        $Villaowner = $this->getNormalizedList($VillaownersArray);
        return response()->json(['Data' => $Villaowner, 'RecordCount' => $VillaownersCount], 200);
    }

    public function getFromUser($id, Request $request)
    {
        $UserPlaces = trapp_villaowner::where('user_fid', '=', $id)->get();
        if (!$UserPlaces->isEmpty())
            return $this->get($UserPlaces[0]->id, $request);
        else
            throw new NotFoundHttpException('Villa Owner Not Found');
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.villaowner.view'))
        //throw new AccessDeniedHttpException();
        $Villaowner = trapp_villaowner::find($id);
        $VillaownerObjectAsArray = $Villaowner->toArray();
        $UserObject = $Villaowner->user();
        $UserObject = $UserObject == null ? '' : $UserObject;
        $VillaownerObjectAsArray['userinfo'] = $this->getNormalizedItem($UserObject->toArray());
        $AreaField = $Villaowner->placemanarea();
        $CityField = $AreaField == null ? '' : $AreaField->city();
        $ProvinceField = $CityField == null ? '' : $CityField->province();
        $VillaownerObjectAsArray['placemanareainfo'] = $AreaField == null ? '' : $AreaField;
        $VillaownerObjectAsArray['cityinfo'] = $CityField == null ? '' : $CityField;
        $VillaownerObjectAsArray['provinceinfo'] = $ProvinceField == null ? '' : $ProvinceField;
        $Villaowner = $this->getNormalizedItem($VillaownerObjectAsArray);
        return response()->json(['Data' => $Villaowner], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.villaowner.delete'))
            throw new AccessDeniedHttpException();
        $Villaowner = trapp_villaowner::find($id);
        $Villaowner->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}