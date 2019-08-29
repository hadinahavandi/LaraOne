<?php

namespace App\Http\Controllers\trapp\API;

use App\models\trapp\trapp_option;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class OptionController extends SweetController
{
    private $ModuleName = 'trapp';

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.option.insert'))
            throw new AccessDeniedHttpException();

        $InputName = $request->input('name');
        $InputFree = 1;
        $InputCountable = 1;

        $Option = trapp_option::create(['name' => $InputName, 'is_free' => $InputFree, 'is_countable' => $InputCountable, 'deletetime' => -1]);
        return response()->json(['Data' => $Option], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.option.edit'))
            throw new AccessDeniedHttpException();

        $InputName = $request->get('name');
//		$InputFree=$request->get('free');
//		$InputCountable=$request->get('countable');;


        $Option = new trapp_option();
        $Option = $Option->find($id);
        $Option->name = $InputName;
//        $Option->is_free=$InputFree;
//        $Option->is_countable=$InputCountable;
        $Option->save();
        return response()->json(['Data' => $Option], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.option.insert');
        Bouncer::allow('admin')->to('trapp.option.edit');
        Bouncer::allow('admin')->to('trapp.option.list');
        Bouncer::allow('admin')->to('trapp.option.view');
        Bouncer::allow('admin')->to('trapp.option.delete');
        //if(!Bouncer::can('trapp.option.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $OptionQuery = trapp_option::where('id', '>=', '0');
        $OptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($OptionQuery, 'name', $SearchText);
        $OptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($OptionQuery, 'name', $request->get('name'));
        $OptionQuery = SweetQueryBuilder::OrderIfNotNull($OptionQuery, 'name__sort', 'name', $request->get('name__sort'));
        $OptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($OptionQuery, 'is_free', $request->get('free'));
        $OptionQuery = SweetQueryBuilder::OrderIfNotNull($OptionQuery, 'free__sort', 'is_free', $request->get('free__sort'));
        $OptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($OptionQuery, 'is_countable', $request->get('countable'));
        $OptionQuery = SweetQueryBuilder::OrderIfNotNull($OptionQuery, 'countable__sort', 'is_countable', $request->get('countable__sort'));
        $OptionsCount = $OptionQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $OptionsCount], 200);
        $Options = SweetQueryBuilder::setPaginationIfNotNull($OptionQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $OptionsArray = [];
        for ($i = 0; $i < count($Options); $i++) {
            $OptionsArray[$i] = $Options[$i]->toArray();
        }
        $Option = $this->getNormalizedList($OptionsArray);
        return response()->json(['Data' => $Option, 'RecordCount' => $OptionsCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.option.view'))
        //throw new AccessDeniedHttpException();
        $Option = trapp_option::find($id);
        $OptionObjectAsArray = $Option->toArray();
        $Option = $this->getNormalizedItem($OptionObjectAsArray);
        return response()->json(['Data' => $Option], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.option.delete'))
            throw new AccessDeniedHttpException();
        $Option = trapp_option::find($id);
        $Option->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}