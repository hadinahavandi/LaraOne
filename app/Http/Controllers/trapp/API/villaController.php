<?php

namespace App\Http\Controllers\trapp\API;

use App\Classes\KavehNegarClient;
use App\Classes\Sweet\SweetDBFile;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Http\Controllers\finance\classes\PayDotIr;
use App\Http\Controllers\finance\classes\unsuccessfulPaymentException;
use App\models\finance\finance_transaction;
use App\models\placeman\placeman_place;
use App\models\placeman\placeman_placephoto;
use App\models\trapp\trapp_areatype;
use App\models\trapp\trapp_order;
use App\models\trapp\trapp_owningtype;
use App\models\trapp\trapp_structuretype;
use App\models\trapp\trapp_viewtype;
use App\models\trapp\trapp_villa;
use App\Http\Controllers\Controller;
use App\models\trapp\trapp_villaowner;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use App\User;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\trapp\trapp_villaAddRequest;
use App\Http\Requests\trapp\trapp_villaUpdateRequest;

class VillaController extends SweetController
{
    private $ModuleName = 'trapp';
    private $_payDotIrApiCode = "598b9a1afff447b50fbdcfcec969d820";//trapp.sweetsoft.ir

//private $_payDotIrApiCode="9b92388e553ba7fd7e3a6d3f28facc45";//JspTutorial.sweetsoft.ir
    public function add(trapp_villaAddRequest $request)
    {
//        if (!Bouncer::can('trapp.villa.insert'))
//            throw new AccessDeniedHttpException();


//        $request->validated();
//        $this->_validateFields($request, false);
        $InputRoomcountnum = $request->input('roomcountnum', 0);
        $InputCapacitynum = $request->input('capacitynum', 0);
        $InputMaxguestsnum = $request->input('maxguestsnum', 0);
        $InputStructureareanum = $request->input('structureareanum', 0);
        $InputTotalareanum = $request->input('totalareanum', 0);
        $InputPlacemanplace = $request->input('placemanplace', -1);
        $InputAddedbyowner = $request->input('addedbyowner', 0);
        $InputViewtype = $request->input('viewtype', -1);
        $InputStructuretype = $request->input('structuretype', -1);
        $InputFulltimeservice = $request->input('fulltimeservice', 0);
        $InputTimestartclk = $request->input('timestartclk', '');
        $InputOwningtype = $request->input('owningtype', -1);
        $InputAreatype = $request->input('areatype', -1);
        $InputDescriptionte = ' ';
        $InputNormalpriceprc = $request->input('normalpriceprc', 0);
        $InputHolidaypriceprc = $request->input('holidaypriceprc', 0);
        $InputWeeklyoffnum = $request->input('weeklyoffnum', 0);
        $InputMonthlyoffnum = $request->input('monthlyoffnum', 0);

        $Villa = trapp_villa::create(['documentphoto_igu' => '', 'roomcount_num' => $InputRoomcountnum, 'capacity_num' => $InputCapacitynum, 'maxguests_num' => $InputMaxguestsnum, 'structurearea_num' => $InputStructureareanum, 'totalarea_num' => $InputTotalareanum, 'placeman_place_fid' => $InputPlacemanplace, 'is_addedbyowner' => $InputAddedbyowner, 'viewtype_fid' => $InputViewtype, 'structuretype_fid' => $InputStructuretype, 'is_fulltimeservice' => $InputFulltimeservice, 'timestart_clk' => $InputTimestartclk, 'owningtype_fid' => $InputOwningtype, 'areatype_fid' => $InputAreatype, 'description_te' => $InputDescriptionte, 'normalprice_prc' => $InputNormalpriceprc, 'holidayprice_prc' => $InputHolidaypriceprc, 'weeklyoff_num' => $InputWeeklyoffnum, 'monthlyoff_num' => $InputMonthlyoffnum, 'deletetime' => -1]);

        $InputDocumentphotoigu = new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE, $this->ModuleName, 'villa', 'documentphoto', $Villa->id, 'jpg');
        $Villa->documentphoto_igu = $InputDocumentphotoigu->uploadFromRequest($request->file('documentphotoigu'));
        $Villa->save();
        return response()->json(['Data' => $Villa], 201);
    }

    private function _getPhotoLocationFromID($ID)
    {
        return 'img/trapp/villa/villa-' . $ID;
    }

    public function update($id, trapp_villaUpdateRequest $request)
    {
//        if (!Bouncer::can('trapp.villa.edit'))
//            throw new AccessDeniedHttpException();
//        $request->setIsUpdate(true);
//        $request->validated();
//        $this->_validateFields($request, true);
        $InputRoomcountnum = $request->get('roomcountnum', 0);
        $InputCapacitynum = $request->get('capacitynum', 0);
        $InputMaxguestsnum = $request->get('maxguestsnum', 0);
        $InputStructureareanum = $request->get('structureareanum', 0);
        $InputTotalareanum = $request->get('totalareanum', 0);
        $InputPlacemanplace = $request->get('placemanplace', -1);
        $InputAddedbyowner = $request->get('addedbyowner', 0);
        $InputViewtype = $request->get('viewtype', -1);
        $InputStructuretype = $request->get('structuretype', -1);
        $InputFulltimeservice = $request->get('fulltimeservice', 0);
        $InputTimestartclk = $request->get('timestartclk', 0);
        $InputOwningtype = $request->get('owningtype', -1);
        $InputAreatype = $request->get('areatype', -1);
        $InputDescriptionte = $request->get('descriptionte', '');
        $InputDocumentphotoigu = $request->file('documentphotoigu');
        if ($InputDocumentphotoigu != null) {
            $InputDocumentphotoigu->move($this->_getPhotoLocationFromID($id), 'main.jpg');
            $InputDocumentphotoigu = $this->_getPhotoLocationFromID($id) . '/main.jpg';
        } else {
            $InputDocumentphotoigu = '';
        }
        $InputNormalpriceprc = $request->get('normalpriceprc');
        $InputHolidaypriceprc = $request->get('holidaypriceprc');
        $InputWeeklyoffnum = $request->get('weeklyoffnum');
        $InputMonthlyoffnum = $request->get('monthlyoffnum');;


        $Villa = new trapp_villa();
        $Villa = $Villa->find($id);
        $Villa->roomcount_num = $InputRoomcountnum;
        $Villa->capacity_num = $InputCapacitynum;
        $Villa->maxguests_num = $InputMaxguestsnum;
        $Villa->structurearea_num = $InputStructureareanum;
        $Villa->totalarea_num = $InputTotalareanum;
        $Villa->placeman_place_fid = $InputPlacemanplace;
        $Villa->is_addedbyowner = $InputAddedbyowner;
        $Villa->viewtype_fid = $InputViewtype;
        $Villa->structuretype_fid = $InputStructuretype;
        $Villa->is_fulltimeservice = $InputFulltimeservice;
        $Villa->timestart_clk = $InputTimestartclk;
        $Villa->owningtype_fid = $InputOwningtype;
        $Villa->areatype_fid = $InputAreatype;
        $Villa->description_te = $InputDescriptionte;
        if ($InputDocumentphotoigu != null)
            $Villa->documentphoto_igu = $InputDocumentphotoigu;
        $Villa->normalprice_prc = $InputNormalpriceprc;
        $Villa->holidayprice_prc = $InputHolidaypriceprc;
        $Villa->weeklyoff_num = $InputWeeklyoffnum;
        $Villa->monthlyoff_num = $InputMonthlyoffnum;
        $Villa->save();
        return response()->json(['Data' => $Villa], 202);
    }

    public function list(Request $request)
    {
        return $this->_baselist('1', $request);
    }

    public function inactiveList(Request $request)
    {
        return $this->_baselist('0', $request);
    }

    private function _baselist($isActive, Request $request)
    {
        Bouncer::allow('admin')->to('trapp.villa.insert');
        Bouncer::allow('admin')->to('trapp.villa.edit');
        Bouncer::allow('admin')->to('trapp.villa.list');
        Bouncer::allow('admin')->to('trapp.villa.view');
        Bouncer::allow('admin')->to('trapp.villa.delete');

        $SortsTEST = [];
//        Auth::user()->getAuthIdentifier();
        //if(!Bouncer::can('trapp.villa.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $UserLatitude = $request->get('userlatitude');
        $UserLongitude = $request->get('userlongitude');
//        $VillaQuery = trapp_villa::where('id','>=','0');
        $VillaQuery = trapp_villa::join('placeman_place', 'placeman_place.id', '=', 'trapp_villa.placeman_place_fid')
            ->join('placeman_area', 'placeman_area.id', '=', 'placeman_place.area_fid')
            ->join('placeman_city', 'placeman_city.id', '=', 'placeman_area.city_id');
        $VillaQuery = $VillaQuery->join('trapp_villaowner', 'trapp_villaowner.user_fid', '=', 'placeman_place.user_fid');
        $VillaQuery = $VillaQuery->where('placeman_place.isactive', '=', $isActive);
        $DateStart = $request->get('selectedstartdate');
        $days = $request->get('days');
        if ($DateStart != null && $days != null) {
            $DateStart = Jalalian::fromFormat('Y/m/d', $DateStart)->getTimestamp();
            $DayLength = 3600 * 24;
            $DateEnd = $DateStart + $days * $DayLength;
            $VillaQuery = $VillaQuery->whereRaw("(SELECT COUNT(*) FROM trapp_order o WHERE o.orderstatus_fid=2 and o.villa_fid=trapp_villa.id and o.start_date>=$DateStart and o.start_date+(o.duration_num*86400)<=$DateEnd)=0");

        }
        $DistanceField = null;
        if ($UserLatitude > 0 && $UserLatitude > 0) {
            $validator = Validator::make($request->all(), [
                'userlongitude' => 'required|numeric',
                'userlatitude' => 'required|numeric'
            ]);
            if ($validator->fails()) {
//                throw new ValidationException($validator);
                $DistanceField = null;
                $Distance = 0;
            } else {
                $Distance = "
        ( 6371 * acos( cos( radians($UserLatitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($UserLongitude) ) + sin( radians($UserLatitude) ) * sin( radians( latitude ) ) ) ) AS `distance`
        ";
                $DistanceField = DB::raw($Distance);
                if ($request->get('distance__sort') != null) {
                    $VillaQuery = $VillaQuery->orderByRaw('distance');
                    $SortsTEST['dist'] = 1;
                }
            }

        }
        if ($request->get('normalpriceprc__sort') != null) {
            $VillaQuery = $VillaQuery->orderBy("normalprice_prc", 'asc');
            $SortsTEST['normalpriceprc__sort'] = 1;
        }
//        $VillaQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery,'roomcount_num',$SearchText);
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'roomcount_num', $request->get('roomcountnum'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'city_id', $request->get('selectedcityvalue'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'roomcountnum__sort', 'roomcount_num', $request->get('roomcountnum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'capacity_num', $request->get('capacitynum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'capacitynum__sort', 'capacity_num', $request->get('capacitynum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'maxguests_num', $request->get('maxguestsnum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'maxguestsnum__sort', 'maxguests_num', $request->get('maxguestsnum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'structurearea_num', $request->get('structureareanum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'structureareanum__sort', 'structurearea_num', $request->get('structureareanum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'totalarea_num', $request->get('totalareanum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'totalareanum__sort', 'totalarea_num', $request->get('totalareanum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'placeman_place_fid', $request->get('placemanplace'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'placemanplace__sort', 'placeman_place_fid', $request->get('placemanplace__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'is_addedbyowner', $request->get('addedbyowner'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'addedbyowner__sort', 'is_addedbyowner', $request->get('addedbyowner__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'viewtype_fid', $request->get('viewtype'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'viewtype__sort', 'viewtype_fid', $request->get('viewtype__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'structuretype_fid', $request->get('structuretype'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'structuretype__sort', 'structuretype_fid', $request->get('structuretype__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'is_fulltimeservice', $request->get('fulltimeservice'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'fulltimeservice__sort', 'is_fulltimeservice', $request->get('fulltimeservice__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'timestart_clk', $request->get('timestartclk'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'timestartclk__sort', 'timestart_clk', $request->get('timestartclk__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'owningtype_fid', $request->get('owningtype'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'owningtype__sort', 'owningtype_fid', $request->get('owningtype__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'areatype_fid', $request->get('areatype'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'areatype__sort', 'areatype_fid', $request->get('areatype__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'description_te', $request->get('descriptionte'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'descriptionte__sort', 'description_te', $request->get('descriptionte__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'normalprice_prc', $request->get('normalpriceprc'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'holidayprice_prc', $request->get('holidaypriceprc'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'holidaypriceprc__sort', 'holidayprice_prc', $request->get('holidaypriceprc__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'weeklyoff_num', $request->get('weeklyoffnum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'weeklyoffnum__sort', 'weeklyoff_num', $request->get('weeklyoffnum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'monthlyoff_num', $request->get('monthlyoffnum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'monthlyoffnum__sort', 'monthlyoff_num', $request->get('monthlyoffnum__sort'));
        $SelectFields = ['trapp_villaowner.*', 'trapp_villaowner.id AS villaownerid', 'trapp_villa.*'];
        if ($DistanceField != null)
            array_push($SelectFields, $DistanceField);
        $VillasCount = $VillaQuery->get($SelectFields)->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $VillasCount], 200);
        $Villas = SweetQueryBuilder::setPaginationIfNotNull($VillaQuery, $request->get('__startrow'), $request->get('__pagesize'))->get($SelectFields);
        $VillasArray = [];
        for ($i = 0; $i < count($Villas); $i++) {
            $VillasArray[$i] = $Villas[$i]->toArray();
            $PlacemanplaceField = $Villas[$i]->placemanplace();
            $VillasArray[$i]['placemanplacecontent'] = $PlacemanplaceField == null ? '' : $PlacemanplaceField->area()->city()->province()->title . ' ' . $PlacemanplaceField->area()->city()->title;
            $ViewtypeField = $Villas[$i]->viewtype();
            $VillasArray[$i]['viewtypecontent'] = $ViewtypeField == null ? '' : $ViewtypeField->name;
            $StructuretypeField = $Villas[$i]->structuretype();
            $VillasArray[$i]['structuretypecontent'] = $StructuretypeField == null ? '' : $StructuretypeField->name;
            $OwningtypeField = $Villas[$i]->owningtype();
            $VillasArray[$i]['owningtypecontent'] = $OwningtypeField == null ? '' : $OwningtypeField->name;
            $AreatypeField = $Villas[$i]->areatype();
            $VillasArray[$i]['areatypecontent'] = $AreatypeField == null ? '' : $AreatypeField->name;
            $Photos = placeman_placephoto::where('place_fid', '=', $PlacemanplaceField->id)->get();
            $VillasArray[$i]['photo'] = '';
            if (!$Photos->isEmpty()) {
                $thumbPath = '/var/www/html/public/' . $Photos[0]->photo_igu . "thumb";
                if (file_exists($thumbPath))
                    $VillasArray[$i]['photo'] = base64_encode(file_get_contents($thumbPath));
            }

        }
        $Villa = $this->getNormalizedList($VillasArray);
        return response()->json(['Data' => $Villa, 'ss' => $SortsTEST, 'RecordCount' => $VillasCount], 200);
    }

    private function resizeAndGetBase64($ImageURL)
    {

    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.villa.view'))
        //throw new AccessDeniedHttpException();
        $Villa = trapp_villa::find($id);
        $VillaObjectAsArray = $Villa->toArray();
        $PlacemanplaceObject = $Villa->placemanplace();
        $PlacemanplaceObject = $PlacemanplaceObject == null ? '' : $PlacemanplaceObject;
        $VillaObjectAsArray['placemanplaceinfo'] = $this->getNormalizedItem($PlacemanplaceObject->toArray());
        $area = $PlacemanplaceObject->area();
        $city = $area->city();
        $province = $city->province();

        $VillaObjectAsArray['placemanplaceinfo']['areainfo'] = $this->getNormalizedItem($area->toArray());
        $VillaObjectAsArray['placemanplaceinfo']['cityinfo'] = $this->getNormalizedItem($city->toArray());
        $VillaObjectAsArray['placemanplaceinfo']['provinceinfo'] = $this->getNormalizedItem($province->toArray());
        $ViewtypeObject = $Villa->viewtype();
        $ViewtypeObject = $ViewtypeObject == null ? '' : $ViewtypeObject;
        $VillaObjectAsArray['viewtypeinfo'] = $this->getNormalizedItem($ViewtypeObject->toArray());
        $Photos = $Villa->photos();
        $Photos = $Photos == null ? '' : $Photos;
        $VillaObjectAsArray['villaphotos'] = $this->getNormalizedList($Photos->toArray());

        $VillaOwnersObject = $Villa->villaOwners()[0];
        $VillaObjectAsArray['villaowner'] = $this->getNormalizedItem($VillaOwnersObject->toArray());

        $VillaOptions = $Villa->options();
        $VillaObjectAsArray['options'] = $this->getNormalizedItem($VillaOptions['data']);

        $StructuretypeObject = $Villa->structuretype();
        $StructuretypeObject = $StructuretypeObject == null ? '' : $StructuretypeObject;
        $VillaObjectAsArray['structuretypeinfo'] = $this->getNormalizedItem($StructuretypeObject->toArray());
        $OwningtypeObject = $Villa->owningtype();
        $OwningtypeObject = $OwningtypeObject == null ? '' : $OwningtypeObject;
        $VillaObjectAsArray['owningtypeinfo'] = $this->getNormalizedItem($OwningtypeObject->toArray());
        $AreatypeObject = $Villa->areatype();
        $AreatypeObject = $AreatypeObject == null ? '' : $AreatypeObject;
        $VillaObjectAsArray['areatypeinfo'] = $this->getNormalizedItem($AreatypeObject->toArray());
        $VillaObjectAsArray['reservedbyuser'] = $this->villaIsReservedByCurrentUser($id);
        $Villa = $this->getNormalizedItem($VillaObjectAsArray);
        return response()->json(['Data' => $Villa], 200);
    }

    private function _GetOrderPrice($VillaID, $DateStart, $Duration)
    {
//        if(!Bouncer::can('trapp.villa.delete'))
//            throw new AccessDeniedHttpException();
        if (!is_numeric($Duration))
            return ['price' => 0];
        $Villa = trapp_villa::find($VillaID);
        $DateStart = SweetDateManager::getTimeStampFromString($DateStart);
        $DayLength = 3600 * 24;
        $Price = 0;
        for ($Date = $DateStart + 0; $Date < ($DateStart + $Duration * $DayLength); $Date += $DayLength) {
            if (SweetDateManager::isholiday($Date))
                $Price = $Price + $Villa->holidayprice_prc;
            else
                $Price = $Price + $Villa->normalprice_prc;
        }
        if ($Duration > 29)
            $Price = $Price * (100 - $Villa->monthlyoff_num) / 100;
        elseif ($Duration > 6)
            $Price = $Price * (100 - $Villa->weeklyoff_num) / 100;
        return ['price' => $Price];
    }

    public function GetOrderPrice($VillaID, Request $request)
    {
//        if(!Bouncer::can('trapp.villa.delete'))
//            throw new AccessDeniedHttpException();
        $DateStart = $request->get('datestart');
        $Duration = $request->get('duration');
        $Data = $this->_GetOrderPrice($VillaID, $DateStart, $Duration);
        return response()->json(['message' => 'ok', 'dt' => [$DateStart], 'Data' => $Data], 201);
    }

    public function StartReservePayment($VillaID, Request $request)
    {
        $DateStart = $request->get('datestart');
        $Duration = $request->get('duration');
        $DateStartTimeStamp = Jalalian::fromFormat('Y/m/d', $DateStart)->getTimestamp();
        $now = time();
        $MinDistanceFromReserveStart = 3600 * 2;
        if ($DateStartTimeStamp - $now < $MinDistanceFromReserveStart)
            return response()->json(['message' => 'تاریخ شروع اقامت گذشته است.', 'Data' => []], 422);
        if (!trapp_villa::getIsVillaReservable($VillaID, $DateStartTimeStamp, $Duration))
            return response()->json(['message' => 'این ویلا در مدت زمات تعیین شده، رزرو شده است.', 'Data' => []], 422);
        $Data = $this->_GetOrderPrice($VillaID, $DateStart, $Duration);
        $Price = $Data['price'];
        if ($Price > 0) {
            $Order = trapp_order::create(['price_prc' => $Price, 'start_date' => $DateStartTimeStamp, 'duration_num' => $Duration,
                'villa_fid' => $VillaID,
                'orderstatus_fid' => 1,
                'user_fid' => Auth::user()->getAuthIdentifier()
            ]);
            $Transaction = PayDotIr::newTransaction($this->_payDotIrApiCode, $Price, 'VillaReserve', 'http://trapp.sweetsoft.ir/trapp/villa/reserveverify/' . $Order->id);
            if ($Transaction['transactionid'] == '-2')
                return response()->json(['message' => 'مبلغ مورد قابل پرداخت نیست', 'Data' => []], 422);

            $Order->reserve__finance_transaction_fid = $Transaction['finance_transaction']->id;
            $Order->save();
            return response()->json(['message' => 'ok', 'dt' => [$DateStart], 'Data' => ['transaction' => $Transaction, 'order' => $Order]], 201);
        }
        return response()->json(['message' => 'مبلغ مورد نظر صحیح نیست', 'Data' => []], 422);

    }

    public function verifyPaymentAndReserve($OrderID, Request $request)
    {
        $Order = trapp_order::find($OrderID);
        $Villa = trapp_villa::find($Order->villa_fid);
        $OwnerUserID = $Villa->villaOwners()[0]->user_fid;
        $ownerUser = User::find($OwnerUserID);
        $Transaction = $Order->reservefinancetransaction();
        $user_id = $Transaction->user_fid;
        $reserverUser = User::find($user_id);
        if ($Order->orderstatus_fid == 2)
            return view("trapp/Payment", ["success" => false, "message" => "وضعیت تراکنش قبلا ثبت شده و رزرو با موفقیت انجام شده است.", "orderID" => $Order->id, "owner" => $ownerUser, "reserver" => $reserverUser, 'villa' => $Villa]);
        $DateStartTimeStamp = Jalalian::forge($Order->start_date)->format('Y/m/d');
        $DayLength = 3600 * 24;
//        $DateEndTimeStamp='';

        if (!trapp_villa::getIsVillaReservable($Order->villa_fid, $DateStartTimeStamp, $Order->duration_num))
            return view("trapp/Payment", ["message" => "عملیات رزرو با خطا مواجه شد. در صورتی که مبلغی از حساب شما کم شود، تا 72 ساعت آینده به حساب شما باز خواهد گشت", "orderID" => 0, "owner" => 0, "reserver" => 0, 'villa' => 0]);
        $EndDate = ((int)$Order->start_date) + $DayLength * $Order->duration_num;
        $DateEndTimeStamp = Jalalian::forge($EndDate)->format('Y/m/d');

        $status = $request->get('status');
        if ($status == 1) {
            $Transaction->status = 3;
            $Transaction->save();
            try {
                $result = PayDotIr::verify($this->_payDotIrApiCode, $Transaction->transactionid);
                if ($result->status == '1') {
                    $Transaction = finance_transaction::create(['amount_prc' => (-1 * $Transaction->amount_prc), 'transactionid' => '-1', 'status' => 3, 'user_fid' => $user_id, 'description_te' => 'Reservation Of Villa ' . $Villa->id]);
                    $Order->orderstatus_fid = 2;
                    $Order->save();
                    $Transaction = finance_transaction::create(['amount_prc' => ($Transaction->amount_prc), 'transactionid' => $Transaction->transactionid, 'status' => 3, 'user_fid' => $OwnerUserID, 'description_te' => 'Money Of Reservation Of ' . $Villa->id]);
//                    $Order->orderstatus_fid = 2;
//                    $Order->save();
                    $opC = new KavehNegarClient("1000800808");
//                    return $ownerUser;
//                    $opC->sendMessage($reserverUser->phone, 'Trapp.ir \r\n'.$reserverUser->name." عزیز، رزرو ویلا با کد $Villa->id با موفقیت انجام شد.");

                    $opC = new KavehNegarClient("1000800808");
                    $opC->sendTokenMessage($reserverUser->phone, $reserverUser->name, $Villa->id, $DateStartTimeStamp . ' تا تاریخ ' . $DateEndTimeStamp, 'userreserve');
                    $opC->sendTokenMessage($ownerUser->phone, $ownerUser->name, $Villa->id, $DateStartTimeStamp . ' تا تاریخ ' . $DateEndTimeStamp, 'ownerreserve');

//                    $opC->sendMessage($reserverUser->phone, $reserverUser->name . " عزیز، رزرو ویلا با کد " . $Villa->id . ' از تاریخ ' . $DateStartTimeStamp . ' تا تاریخ ' . $DateEndTimeStamp . " با موفقیت انجام شد." . '
//Trapp');
//                    $opC->sendMessage($ownerUser->phone, $ownerUser->name . " عزیز، رزرو ویلای شما با کد " . $Villa->id . ' از تاریخ ' . $DateStartTimeStamp . ' تا تاریخ ' . $DateEndTimeStamp . " با موفقیت انجام شد." . '
//Trapp');
                    return view("trapp/Payment", ["success" => true, "message" => "پرداخت با موفقیت انجام شد.", "orderID" => $OrderID, "owner" => $ownerUser, "reserver" => $reserverUser, 'villa' => $Villa]);

                }
            } catch (unsuccessfulPaymentException $ex) {
                return view("trapp/Payment", ["success" => false, "message" => "پرداخت ناموفق انجام شد." . $ex->getMessage(), "orderID" => $OrderID, "owner" => $ownerUser, "reserver" => $reserverUser, 'villa' => $Villa]);

            }
            return view("trapp/Payment", ["success" => false, "message" => "پرداخت به طور کامل انجام نشد.", "orderID" => $OrderID, "owner" => $ownerUser, "reserver" => $reserverUser, 'villa' => $Villa]);
        }
        return view("trapp/Payment", ["message" => "پرداخت انجام نشد."]);
    }

    public function testPayment($OrderID, Request $request)
    {

        return view("trapp/testPayment", ["data" => $OrderID]);
    }

    public function villaIsReservedByCurrentUser($VillaID)
    {
//        return true;
        $user = Auth::user();
        if ($user != null) {

            $UserPlaces = trapp_order::where('user_fid', '=', $user->id);
            $UserPlaces = $UserPlaces->where('villa_fid', '=', $VillaID);
            $UserPlaces = $UserPlaces->where('orderstatus_fid', '=', 2)->get();
            return !($UserPlaces->isEmpty());
        }
        return false;
    }

    public function getUserFullInfo(Request $request)
    {
        $user = Auth::user();
        $UserPlaces = placeman_place::where('user_fid', '=', $user->id)->get();
        $UserVillas = trapp_villa::getUserVillas($user->id);
        $UserVillaOwners = trapp_villaowner::getUserVillaOwners($user->id);
        return response()->json(['Data' => ['places' => $UserPlaces, 'villas' => $UserVillas, 'owners' => $UserVillaOwners]], 202);

    }

    public function getReservedDaysOfVilla($VillaId, Request $request)
    {
        $days = trapp_villa::getReservedDaysOfVilla($VillaId);
        return response()->json(['Data' => ['dates' => $days]], 202);

    }

    public function getRelatedOptions(Request $request)
    {
        $result = [];
        $result['viewtypes'] = $this->getNormalizedList(trapp_viewtype::all()->toArray());
        $result['structuretypes'] = $this->getNormalizedList(trapp_structuretype::all()->toArray());
        $result['owningtypes'] = $this->getNormalizedList(trapp_owningtype::all()->toArray());
        $result['areatypes'] = $this->getNormalizedList(trapp_areatype::all()->toArray());
        return response()->json(['Data' => $result], 200);

    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.villa.delete'))
            throw new AccessDeniedHttpException();
        $Villa = trapp_villa::find($id);
        $Villa->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}