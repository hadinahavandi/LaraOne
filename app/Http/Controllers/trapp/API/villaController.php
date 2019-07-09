<?php

namespace App\Http\Controllers\trapp\API;

use App\Http\Controllers\common\classes\SweetDateManager;
use App\Http\Controllers\finance\classes\PayDotIr;
use App\models\finance\finance_transaction;
use App\models\placeman\placeman_place;
use App\models\trapp\trapp_order;
use App\models\trapp\trapp_villa;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VillaController extends SweetController
{

    public function add(Request $request)
    {
//        if (!Bouncer::can('trapp.villa.insert'))
//            throw new AccessDeniedHttpException();

        $InputRoomcountnum = $request->input('roomcountnum');
        $InputCapacitynum = $request->input('capacitynum');
        $InputMaxguestsnum = $request->input('maxguestsnum');
        $InputStructureareanum = $request->input('structureareanum');
        $InputTotalareanum = $request->input('totalareanum');
        $InputPlacemanplace = $request->input('placemanplace');
        $InputAddedbyowner = $request->input('addedbyowner');
        $InputViewtype = $request->input('viewtype');
        $InputStructuretype = $request->input('structuretype');
        $InputFulltimeservice = $request->input('fulltimeservice');
        $InputTimestartclk = $request->input('timestartclk');
        $InputOwningtype = $request->input('owningtype');
        $InputAreatype = $request->input('areatype');
        $InputDescriptionte = $request->input('descriptionte');
        $InputDocumentphotoigu = $request->file('documentphotoigu');
        if ($InputDocumentphotoigu != null) {
            $InputDocumentphotoigu->move('img/trapp/villa', $InputDocumentphotoigu->getClientOriginalName());
            $InputDocumentphotoigu = 'img/trapp/villa/' . $InputDocumentphotoigu->getClientOriginalName();
        } else {
            $InputDocumentphotoigu = '';
        }
        $InputNormalpriceprc = $request->input('normalpriceprc');
        $InputHolidaypriceprc = $request->input('holidaypriceprc');
        $InputWeeklyoffnum = $request->input('weeklyoffnum');
        $InputMonthlyoffnum = $request->input('monthlyoffnum');

        $Villa = trapp_villa::create(['roomcount_num' => $InputRoomcountnum, 'capacity_num' => $InputCapacitynum, 'maxguests_num' => $InputMaxguestsnum, 'structurearea_num' => $InputStructureareanum, 'totalarea_num' => $InputTotalareanum, 'placeman_place_fid' => $InputPlacemanplace, 'is_addedbyowner' => $InputAddedbyowner, 'viewtype_fid' => $InputViewtype, 'structuretype_fid' => $InputStructuretype, 'is_fulltimeservice' => $InputFulltimeservice, 'timestart_clk' => $InputTimestartclk, 'owningtype_fid' => $InputOwningtype, 'areatype_fid' => $InputAreatype, 'description_te' => $InputDescriptionte, 'documentphoto_igu' => $InputDocumentphotoigu, 'normalprice_prc' => $InputNormalpriceprc, 'holidayprice_prc' => $InputHolidaypriceprc, 'weeklyoff_num' => $InputWeeklyoffnum, 'monthlyoff_num' => $InputMonthlyoffnum, 'deletetime' => -1]);
        return response()->json(['Data' => $Villa], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.villa.edit'))
            throw new AccessDeniedHttpException();

        $InputRoomcountnum = $request->get('roomcountnum');
        $InputCapacitynum = $request->get('capacitynum');
        $InputMaxguestsnum = $request->get('maxguestsnum');
        $InputStructureareanum = $request->get('structureareanum');
        $InputTotalareanum = $request->get('totalareanum');
        $InputPlacemanplace = $request->get('placemanplace');
        $InputAddedbyowner = $request->get('addedbyowner');
        $InputViewtype = $request->get('viewtype');
        $InputStructuretype = $request->get('structuretype');
        $InputFulltimeservice = $request->get('fulltimeservice');
        $InputTimestartclk = $request->get('timestartclk');
        $InputOwningtype = $request->get('owningtype');
        $InputAreatype = $request->get('areatype');
        $InputDescriptionte = $request->get('descriptionte');
        $InputDocumentphotoigu = $request->file('documentphotoigu');
        if ($InputDocumentphotoigu != null) {
            $InputDocumentphotoigu->move('img/', $InputDocumentphotoigu->getClientOriginalName());
            $InputDocumentphotoigu = 'img/' . $InputDocumentphotoigu->getClientOriginalName();
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
        Bouncer::allow('admin')->to('trapp.villa.insert');
        Bouncer::allow('admin')->to('trapp.villa.edit');
        Bouncer::allow('admin')->to('trapp.villa.list');
        Bouncer::allow('admin')->to('trapp.villa.view');
        Bouncer::allow('admin')->to('trapp.villa.delete');


//        Auth::user()->getAuthIdentifier();
        //if(!Bouncer::can('trapp.villa.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
//        $VillaQuery = trapp_villa::where('id','>=','0');
        $VillaQuery = trapp_villa::join('placeman_place', 'placeman_place.id', '=', 'trapp_villa.placeman_place_fid')
            ->join('placeman_area', 'placeman_area.id', '=', 'placeman_place.area_fid')
            ->join('placeman_city', 'placeman_city.id', '=', 'placeman_area.city_id');
        if ($request->get('selectedstartdate') != '' && $request->get('days') != '') {
            $DateStart = $request->get('selectedstartdate');
            $days = $request->get('days');
            $DateStart = Jalalian::fromFormat('Y/m/d', $DateStart)->getTimestamp();
            $DayLength = 3600 * 24;
            $DateEnd = $DateStart + $days * $DayLength;
            $VillaQuery = $VillaQuery->whereRaw("(SELECT COUNT(*) FROM trapp_order o WHERE o.orderstatus_fid=2 and o.villa_fid=trapp_villa.id and o.start_date>=$DateStart and o.start_date+(o.duration_num*86400)<=$DateEnd)=0");

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
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'normalpriceprc__sort', 'normalprice_prc', $request->get('normalpriceprc__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'holidayprice_prc', $request->get('holidaypriceprc'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'holidaypriceprc__sort', 'holidayprice_prc', $request->get('holidaypriceprc__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'weeklyoff_num', $request->get('weeklyoffnum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'weeklyoffnum__sort', 'weeklyoff_num', $request->get('weeklyoffnum__sort'));
        $VillaQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaQuery, 'monthlyoff_num', $request->get('monthlyoffnum'));
        $VillaQuery = SweetQueryBuilder::OrderIfNotNull($VillaQuery, 'monthlyoffnum__sort', 'monthlyoff_num', $request->get('monthlyoffnum__sort'));
        $VillasCount = $VillaQuery->get(['trapp_villa.*'])->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $VillasCount], 200);
        $Villas = SweetQueryBuilder::setPaginationIfNotNull($VillaQuery, $request->get('__startrow'), $request->get('__pagesize'))->get(['trapp_villa.*']);
        $VillasArray = [];
        for ($i = 0; $i < count($Villas); $i++) {
            $VillasArray[$i] = $Villas[$i]->toArray();
            $PlacemanplaceField = $Villas[$i]->placemanplace();
            $VillasArray[$i]['placemanplacecontent'] = $PlacemanplaceField == null ? '' : $PlacemanplaceField->name;
            $ViewtypeField = $Villas[$i]->viewtype();
            $VillasArray[$i]['viewtypecontent'] = $ViewtypeField == null ? '' : $ViewtypeField->name;
            $StructuretypeField = $Villas[$i]->structuretype();
            $VillasArray[$i]['structuretypecontent'] = $StructuretypeField == null ? '' : $StructuretypeField->name;
            $OwningtypeField = $Villas[$i]->owningtype();
            $VillasArray[$i]['owningtypecontent'] = $OwningtypeField == null ? '' : $OwningtypeField->name;
            $AreatypeField = $Villas[$i]->areatype();
            $VillasArray[$i]['areatypecontent'] = $AreatypeField == null ? '' : $AreatypeField->name;
        }
        $Villa = $this->getNormalizedList($VillasArray);
        return response()->json(['Data' => $Villa, 'RecordCount' => $VillasCount], 200);
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
        $StructuretypeObject = $Villa->structuretype();
        $StructuretypeObject = $StructuretypeObject == null ? '' : $StructuretypeObject;
        $VillaObjectAsArray['structuretypeinfo'] = $this->getNormalizedItem($StructuretypeObject->toArray());
        $OwningtypeObject = $Villa->owningtype();
        $OwningtypeObject = $OwningtypeObject == null ? '' : $OwningtypeObject;
        $VillaObjectAsArray['owningtypeinfo'] = $this->getNormalizedItem($OwningtypeObject->toArray());
        $AreatypeObject = $Villa->areatype();
        $AreatypeObject = $AreatypeObject == null ? '' : $AreatypeObject;
        $VillaObjectAsArray['areatypeinfo'] = $this->getNormalizedItem($AreatypeObject->toArray());
        $Villa = $this->getNormalizedItem($VillaObjectAsArray);
        return response()->json(['Data' => $Villa], 200);
    }

    private function _GetOrderPrice($VillaID, $DateStart, $Duration)
    {
//        if(!Bouncer::can('trapp.villa.delete'))
//            throw new AccessDeniedHttpException();
        $Villa = trapp_villa::find($VillaID);
        $DateStart = Jalalian::fromFormat('Y/m/d', $DateStart)->getTimestamp();
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
        $Data = $this->_GetOrderPrice($VillaID, $DateStart, $Duration);
        $Price = $Data['price'];
        $Order = trapp_order::create(['price_prc' => $Price, 'start_date' => $DateStartTimeStamp, 'duration_num' => $Duration,
            'villa_fid' => $VillaID,
            'orderstatus_fid' => 1,
            'user_fid' => Auth::user()->getAuthIdentifier()
        ]);
        $Transaction = PayDotIr::newTransaction($Price, 'VillaReserve', 'http://jsptutorial.sweetsoft.ir/trapp/villa/reserveverify/' . $Order->id);

        $Order->reserve__finance_transaction_fid = $Transaction['finance_transaction']->id;
        $Order->save();
        return response()->json(['message' => 'ok', 'dt' => [$DateStart], 'Data' => ['transaction' => $Transaction, 'order' => $Order]], 201);
    }

    public function verifyPaymentAndReserve($OrderID, Request $request)
    {
        $Order = trapp_order::find($OrderID);

        $api = '9b92388e553ba7fd7e3a6d3f28facc45';
        $Transaction = $Order->reservefinancetransaction();
        $Transaction->status = 3;
        $Transaction->save();
        $user_id = $Transaction->user_fid;
        $result = PayDotIr::verify($api, $Transaction->transactionid);
        $Transaction = finance_transaction::create(['amount_prc' => (-1 * $Transaction->amount_prc), 'transactionid' => '-1', 'status' => 3, 'user_fid' => $user_id, 'description_te' => 'Reservation Of ...']);
        $Order->orderstatus_fid = 2;
        $Order->save();
        return "پرداخت با موفقیت انجام شد.";
    }

    public function testPayment($OrderID, Request $request)
    {

        return view("trapp/testPayment", ["data" => $OrderID]);
    }

    public function getUserFullInfo(Request $request)
    {
        $user = Auth::user();
        $UserPlaces = placeman_place::where('user_fid', '=', $user->id)->get();
        $UserVillas = trapp_villa::getUserVillas($user->id);
        return response()->json(['Data' => ['places' => $UserPlaces, 'villas' => $UserVillas]], 202);

    }

    public function getReservedDaysOfVilla($VillaId, Request $request)
    {
        $days = trapp_villa::getReservedDaysOfVilla($VillaId);
        return response()->json(['Data' => ['dates' => $days]], 202);

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