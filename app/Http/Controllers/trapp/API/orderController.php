<?php

namespace App\Http\Controllers\trapp\API;

use App\models\placeman\placeman_place;
use App\models\trapp\trapp_order;
use App\Http\Controllers\Controller;
use App\models\trapp\trapp_villa;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class OrderController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.order.insert'))
            throw new AccessDeniedHttpException();

        $InputPriceprc = $request->input('priceprc');
        $InputReservefinancetransaction = $request->input('reservefinancetransaction');
        $InputCancelfinancetransaction = $request->input('cancelfinancetransaction');
        $InputVilla = $request->input('villa');
        $InputOrderstatus = $request->input('orderstatus');
        $InputStartdate = $request->input('startdate');
        $InputDurationnum = $request->input('durationnum');
        $InputUser = $request->input('user');

        $Order = trapp_order::create(['price_prc' => $InputPriceprc, 'reserve__finance_transaction_fid' => $InputReservefinancetransaction, 'cancel__finance_transaction_fid' => $InputCancelfinancetransaction, 'villa_fid' => $InputVilla, 'orderstatus_fid' => $InputOrderstatus, 'start_date' => $InputStartdate, 'duration_num' => $InputDurationnum, 'user_fid' => $InputUser, 'deletetime' => -1]);
        return response()->json(['Data' => $Order], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.order.edit'))
            throw new AccessDeniedHttpException();

        $InputPriceprc = $request->get('priceprc');
        $InputReservefinancetransaction = $request->get('reservefinancetransaction');
        $InputCancelfinancetransaction = $request->get('cancelfinancetransaction');
        $InputVilla = $request->get('villa');
        $InputOrderstatus = $request->get('orderstatus');
        $InputStartdate = $request->get('startdate');
        $InputDurationnum = $request->get('durationnum');
        $InputUser = $request->get('user');;


        $Order = new trapp_order();
        $Order = $Order->find($id);
        $Order->price_prc = $InputPriceprc;
        $Order->reserve__finance_transaction_fid = $InputReservefinancetransaction;
        $Order->cancel__finance_transaction_fid = $InputCancelfinancetransaction;
        $Order->villa_fid = $InputVilla;
        $Order->orderstatus_fid = $InputOrderstatus;
        $Order->start_date = $InputStartdate;
        $Order->duration_num = $InputDurationnum;
        $Order->user_fid = $InputUser;
        $Order->save();
        return response()->json(['Data' => $Order], 202);
    }

    public function villaorderslist(Request $request)
    {
        $user = Auth::user();
        $UserVillas = trapp_villa::getUserVillas($user->id);
        $villaID = -1;
        if ($UserVillas != null && count($UserVillas) > 0)
            $villaID = $UserVillas[0]->id;
//        if(key_exists(0,$UserVillas))
//            $villaID=$UserVillas[0]->id;
        if ($villaID != '') {
            $OrderQuery = trapp_order::where('id', '>=', '0');
            $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'villa_fid', $villaID);
            $OrderQuery = $OrderQuery->where('orderstatus_fid', '>', 1);
            $OrdersCount = $OrderQuery->get()->count();
            if ($request->get('_onlycount') !== null)
                return response()->json(['Data' => [], 'RecordCount' => $OrdersCount], 200);
            $Orders = SweetQueryBuilder::setPaginationIfNotNull($OrderQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
            $OrdersArray = [];
            for ($i = 0; $i < count($Orders); $i++) {
                $OrdersArray[$i] = $Orders[$i]->toArray();
                $ReservefinancetransactionField = $Orders[$i]->reservefinancetransaction();
                $OrdersArray[$i]['reservefinancetransactioncontent'] = $ReservefinancetransactionField == null ? '' : $ReservefinancetransactionField->name;
                $CancelfinancetransactionField = $Orders[$i]->cancelfinancetransaction();
                $OrdersArray[$i]['cancelfinancetransactioncontent'] = $CancelfinancetransactionField == null ? '' : $CancelfinancetransactionField->name;
                $VillaField = $Orders[$i]->villa();
                $OrdersArray[$i]['villacontent'] = $VillaField == null ? '' : $VillaField->placemanplace()->area()->city()->title;
                $OrderstatusField = $Orders[$i]->orderstatus();
                $OrdersArray[$i]['orderstatuscontent'] = $OrderstatusField == null ? '' : $OrderstatusField->name;
                $UserField = $Orders[$i]->user();
                $OrdersArray[$i]['usercontent'] = $UserField == null ? '' : $UserField->name;
            }
            $Order = $this->getNormalizedList($OrdersArray);
            $days = trapp_villa::getReservedDaysOfVilla($UserVillas[0]->id);
            $reserveddays = $days == null ? [] : $days;
            return response()->json(['Data' => ['orders' => $Order, 'reserveddays' => $reserveddays], 'RecordCount' => $OrdersCount], 200);

        }
        return response()->json(['Data' => ['orders' => [], 'reserveddays' => []], 'message' => 'هیچ ویلایی برای شما ثبت نشده است', 'user' => $user->id, 'villas' => $UserVillas, 'RecordCount' => 0], 200);

    }
    public function list(Request $request)
    {
        return $this->_BaseList(false, $request);
    }

    public function UserOrdersList(Request $request)
    {
        return $this->_BaseList(true, $request);
    }

    private function _BaseList($LoadUserOrders, Request $request)
    {
        Bouncer::allow('admin')->to('trapp.order.insert');
        Bouncer::allow('admin')->to('trapp.order.edit');
        Bouncer::allow('admin')->to('trapp.order.list');
        Bouncer::allow('admin')->to('trapp.order.view');
        Bouncer::allow('admin')->to('trapp.order.delete');
        //if(!Bouncer::can('trapp.order.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $OrderQuery = trapp_order::where('id', '>=', '0');
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'price_prc', $SearchText);
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'price_prc', $request->get('priceprc'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'priceprc__sort', 'price_prc', $request->get('priceprc__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'reserve__finance_transaction_fid', $request->get('reservefinancetransaction'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'reservefinancetransaction__sort', 'reserve__finance_transaction_fid', $request->get('reservefinancetransaction__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'cancel__finance_transaction_fid', $request->get('cancelfinancetransaction'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'cancelfinancetransaction__sort', 'cancel__finance_transaction_fid', $request->get('cancelfinancetransaction__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'villa_fid', $request->get('villa'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'villa__sort', 'villa_fid', $request->get('villa__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'orderstatus_fid', $request->get('orderstatus'));
        if ($LoadUserOrders) {
            $user = Auth::user()->id;
            $OrderQuery = $OrderQuery->where('orderstatus_fid', '>', 1);
            $OrderQuery = $OrderQuery->where('user_fid', '=', $user);
        }

        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'orderstatus__sort', 'orderstatus_fid', $request->get('orderstatus__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'start_date', $request->get('startdate'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'startdate__sort', 'start_date', $request->get('startdate__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'duration_num', $request->get('durationnum'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'durationnum__sort', 'duration_num', $request->get('durationnum__sort'));
        $OrderQuery = SweetQueryBuilder::WhereLikeIfNotNull($OrderQuery, 'user_fid', $request->get('user'));
        $OrderQuery = SweetQueryBuilder::OrderIfNotNull($OrderQuery, 'user__sort', 'user_fid', $request->get('user__sort'));
        $OrdersCount = $OrderQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $OrdersCount], 200);
        $Orders = SweetQueryBuilder::setPaginationIfNotNull($OrderQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $OrdersArray = [];
        for ($i = 0; $i < count($Orders); $i++) {
            $OrdersArray[$i] = $Orders[$i]->toArray();
            $ReservefinancetransactionField = $Orders[$i]->reservefinancetransaction();
            $OrdersArray[$i]['reservefinancetransactioncontent'] = $ReservefinancetransactionField == null ? '' : $ReservefinancetransactionField->name;
            $CancelfinancetransactionField = $Orders[$i]->cancelfinancetransaction();
            $OrdersArray[$i]['cancelfinancetransactioncontent'] = $CancelfinancetransactionField == null ? '' : $CancelfinancetransactionField->name;
            $VillaField = $Orders[$i]->villa();
            $OrdersArray[$i]['villacontent'] = $VillaField == null ? '' : $VillaField->placemanplace()->area()->city()->title;
            $OrderstatusField = $Orders[$i]->orderstatus();
            $OrdersArray[$i]['orderstatuscontent'] = $OrderstatusField == null ? '' : $OrderstatusField->name;
            $UserField = $Orders[$i]->user();
            $OrdersArray[$i]['usercontent'] = $UserField == null ? '' : $UserField->name . " " . $UserField->phone;
        }
        $Order = $this->getNormalizedList($OrdersArray);
        return response()->json(['Data' => $Order, 'RecordCount' => $OrdersCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.order.view'))
        //throw new AccessDeniedHttpException();
        $Order = trapp_order::find($id);
        $OrderObjectAsArray = $Order->toArray();
        $ReservefinancetransactionObject = $Order->reservefinancetransaction();
        $ReservefinancetransactionObject = $ReservefinancetransactionObject == null ? '' : $ReservefinancetransactionObject;
        $OrderObjectAsArray['reservefinancetransactioninfo'] = $this->getNormalizedItem($ReservefinancetransactionObject->toArray());
        $CancelfinancetransactionObject = $Order->cancelfinancetransaction();
        $CancelfinancetransactionObject = $CancelfinancetransactionObject == null ? '' : $CancelfinancetransactionObject;
        $OrderObjectAsArray['cancelfinancetransactioninfo'] = $this->getNormalizedItem($CancelfinancetransactionObject->toArray());
        $VillaObject = $Order->villa();
        $VillaObject = $VillaObject == null ? '' : $VillaObject;
        $OrderObjectAsArray['villainfo'] = $this->getNormalizedItem($VillaObject->toArray());
        $OrderstatusObject = $Order->orderstatus();
        $OrderstatusObject = $OrderstatusObject == null ? '' : $OrderstatusObject;
        $OrderObjectAsArray['orderstatusinfo'] = $this->getNormalizedItem($OrderstatusObject->toArray());
        $UserObject = $Order->user();
        $UserObject = $UserObject == null ? '' : $UserObject;
        $OrderObjectAsArray['userinfo'] = $this->getNormalizedItem($UserObject->toArray());
        $Order = $this->getNormalizedItem($OrderObjectAsArray);
        return response()->json(['Data' => $Order], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.order.delete'))
            throw new AccessDeniedHttpException();
        $Order = trapp_order::find($id);
        $Order->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}