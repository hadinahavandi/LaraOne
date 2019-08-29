<?php

namespace App\Http\Controllers\common\API;

use App\models\common\common_date;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\common\common_dateAddRequest;
use App\Http\Requests\common\common_dateUpdateRequest;

class DateController extends SweetController
{
    private $ModuleName = 'common';

    public function add(common_dateAddRequest $request)
    {
        if (!Bouncer::can('common.date.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();

        $InputDaydate = $request->input('daydate', ' ');
        $InputFactordbl = $request->input('factordbl', 0);

        $Date = common_date::create(['day_date' => $InputDaydate, 'factor_dbl' => $InputFactordbl, 'deletetime' => -1]);
        return response()->json(['Data' => $Date], 201);
    }

    public function update($id, common_dateUpdateRequest $request)
    {
        if (!Bouncer::can('common.date.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputDaydate = $request->get('daydate', ' ');
        $InputFactordbl = $request->get('factordbl', 0);;


        $Date = new common_date();
        $Date = $Date->find($id);
        $Date->day_date = $InputDaydate;
        $Date->factor_dbl = $InputFactordbl;
        $Date->save();
        return response()->json(['Data' => $Date], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('common.date.insert');
        Bouncer::allow('admin')->to('common.date.edit');
        Bouncer::allow('admin')->to('common.date.list');
        Bouncer::allow('admin')->to('common.date.view');
        Bouncer::allow('admin')->to('common.date.delete');
        //if(!Bouncer::can('common.date.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $DateQuery = common_date::where('id', '>=', '0');
        $DateQuery = SweetQueryBuilder::WhereLikeIfNotNull($DateQuery, 'day_date', $SearchText);
        $DateQuery = SweetQueryBuilder::WhereLikeIfNotNull($DateQuery, 'day_date', $request->get('daydate'));
        $DateQuery = SweetQueryBuilder::OrderIfNotNull($DateQuery, 'daydate__sort', 'day_date', $request->get('daydate__sort'));
        $DateQuery = SweetQueryBuilder::WhereLikeIfNotNull($DateQuery, 'factor_dbl', $request->get('factordbl'));
        $DateQuery = SweetQueryBuilder::OrderIfNotNull($DateQuery, 'factordbl__sort', 'factor_dbl', $request->get('factordbl__sort'));
        $DatesCount = $DateQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $DatesCount], 200);
        $Dates = SweetQueryBuilder::setPaginationIfNotNull($DateQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $DatesArray = [];
        for ($i = 0; $i < count($Dates); $i++) {
            $DatesArray[$i] = $Dates[$i]->toArray();
        }
        $Date = $this->getNormalizedList($DatesArray);
        return response()->json(['Data' => $Date, 'RecordCount' => $DatesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('common.date.view'))
        //throw new AccessDeniedHttpException();
        $Date = common_date::find($id);
        $DateObjectAsArray = $Date->toArray();
        $Date = $this->getNormalizedItem($DateObjectAsArray);
        return response()->json(['Data' => $Date], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('common.date.delete'))
            throw new AccessDeniedHttpException();
        $Date = common_date::find($id);
        $Date->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}