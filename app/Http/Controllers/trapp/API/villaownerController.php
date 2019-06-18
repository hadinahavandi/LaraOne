<?php

namespace App\Http\Controllers\trapp\API;

use App\models\placeman_area;
use App\models\trapp\trapp_villaowner;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VillaownerController extends SweetController
{

    public function add(Request $request)
    {
//        if(!Bouncer::can('trapp.villaowner.insert'))
//            throw new AccessDeniedHttpException();
//
        $InputName = $request->input('name');
        $InputUser = Auth::user()->id;
        $InputNationalcode = $request->input('nationalcode');
        $InputAddress = $request->input('address');
        $InputShabacode = $request->input('shabacode');
        $InputTel = $request->input('tel');
        $InputBackuptel = $request->input('backuptel');
        $InputEmail = $request->input('email');
        $InputBackupmobile = $request->input('backupmobile');
        $InputPhotoigu = $request->file('photoigu');
        if ($InputPhotoigu != null) {
            $InputPhotoigu->move('img/', $InputPhotoigu->getClientOriginalName());
            $InputPhotoigu = 'img/' . $InputPhotoigu->getClientOriginalName();
        } else {
            $InputPhotoigu = '';
        }
        $InputNationalcardigu = $request->file('nationalcardigu');
        if ($InputNationalcardigu != null) {
            $InputNationalcardigu->move('img/', $InputNationalcardigu->getClientOriginalName());
            $InputNationalcardigu = 'img/' . $InputNationalcardigu->getClientOriginalName();
        } else {
            $InputNationalcardigu = '';
        }
        $InputPlacemanarea = $request->input('placemanarea');
        $Villaowner = trapp_villaowner::create(['name' => $InputName, 'user_fid' => $InputUser, 'nationalcode' => $InputNationalcode, 'address' => $InputAddress, 'shabacode' => $InputShabacode, 'tel' => $InputTel, 'backuptel' => $InputBackuptel, 'email' => $InputEmail, 'backupmobile' => $InputBackupmobile, 'photo_igu' => $InputPhotoigu, 'nationalcard_igu' => $InputNationalcardigu, 'placeman_area_fid' => $InputPlacemanarea, 'deletetime' => -1]);
        return response()->json(['Data' => $Villaowner], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.villaowner.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
        $InputUser = $request->get('user');
        $InputNationalcode = $request->get('nationalcode');
        $InputAddress = $request->get('address');
        $InputShabacode = $request->get('shabacode');
        $InputTel = $request->get('tel');
        $InputBackuptel = $request->get('backuptel');
        $InputEmail = $request->get('email');
        $InputBackupmobile = $request->get('backupmobile');
        $InputPhotoigu = $request->file('photoigu');
        if ($InputPhotoigu != null) {
            $InputPhotoigu->move('img/', $InputPhotoigu->getClientOriginalName());
            $InputPhotoigu = 'img/' . $InputPhotoigu->getClientOriginalName();
        } else {
            $InputPhotoigu = '';
        }
        $InputNationalcardigu = $request->file('nationalcardigu');
        if ($InputNationalcardigu != null) {
            $InputNationalcardigu->move('img/', $InputNationalcardigu->getClientOriginalName());
            $InputNationalcardigu = 'img/' . $InputNationalcardigu->getClientOriginalName();
        } else {
            $InputNationalcardigu = '';
        }
        $InputPlacemanarea = $request->get('placemanarea');
        $Villaowner = new trapp_villaowner();
        $Villaowner = $Villaowner->find($id);
        $Villaowner->name = $InputName;
        $Villaowner->user_fid = $InputUser;
        $Villaowner->nationalcode = $InputNationalcode;
        $Villaowner->address = $InputAddress;
        $Villaowner->shabacode = $InputShabacode;
        $Villaowner->tel = $InputTel;
        $Villaowner->backuptel = $InputBackuptel;
        $Villaowner->email = $InputEmail;
        $Villaowner->backupmobile = $InputBackupmobile;
        if ($InputPhotoigu != null)
            $Villaowner->photo_igu = $InputPhotoigu;
        if ($InputNationalcardigu != null)
            $Villaowner->nationalcard_igu = $InputNationalcardigu;
        $Villaowner->placeman_area_fid = $InputPlacemanarea;
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
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'nationalcode', $SearchText);
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'name', $request->get('name'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'name__sort', 'name', $request->get('name__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'user_fid', $request->get('user'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'user__sort', 'user_fid', $request->get('user__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'nationalcode', $request->get('nationalcode'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'nationalcode__sort', 'nationalcode', $request->get('nationalcode__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'address', $request->get('address'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'address__sort', 'address', $request->get('address__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'shabacode', $request->get('shabacode'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'shabacode__sort', 'shabacode', $request->get('shabacode__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'tel', $request->get('tel'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'tel__sort', 'tel', $request->get('tel__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'backuptel', $request->get('backuptel'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'backuptel__sort', 'backuptel', $request->get('backuptel__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'email', $request->get('email'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'email__sort', 'email', $request->get('email__sort'));
        $VillaownerQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaownerQuery, 'backupmobile', $request->get('backupmobile'));
        $VillaownerQuery = SweetQueryBuilder::OrderIfNotNull($VillaownerQuery, 'backupmobile__sort', 'backupmobile', $request->get('backupmobile__sort'));
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
            $PlacemanareaField = $Villaowners[$i]->placemanarea();
            $VillaownersArray[$i]['placemanareacontent'] = $PlacemanareaField == null ? '' : $PlacemanareaField->name;
        }
        $Villaowner = $this->getNormalizedList($VillaownersArray);
        return response()->json(['Data' => $Villaowner, 'RecordCount' => $VillaownersCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.villaowner.view'))
        //throw new AccessDeniedHttpException();
        $Villaowner = trapp_villaowner::find($id);
        $VillaownerObjectAsArray = $Villaowner->toArray();
        $UserID = $Villaowner->user_fid;
        $UserObject = $UserID > 0 ? User::find($UserID) : '';
        $VillaownerObjectAsArray['userinfo'] = $this->getNormalizedItem($UserObject->toArray());
        $PlacemanareaID = $Villaowner->placeman_area_fid;
        $PlacemanareaObject = $PlacemanareaID > 0 ? placeman_area::find($PlacemanareaID) : '';
        $VillaownerObjectAsArray['placemanareainfo'] = $this->getNormalizedItem($PlacemanareaObject->toArray());
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