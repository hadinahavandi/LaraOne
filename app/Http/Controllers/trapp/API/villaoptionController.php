<?php

namespace App\Http\Controllers\trapp\API;

use App\Http\Controllers\trapp\classes\villaOption;
use App\models\trapp\trapp_option;
use App\models\trapp\trapp_villaoption;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VillaoptionController extends SweetController
{
    private $ModuleName = 'trapp';

    public function add(Request $request)
    {
        if (!Bouncer::can('trapp.villaoption.insert'))
            throw new AccessDeniedHttpException();

        $InputVilla = $request->input('villa');
        $InputOption = $request->input('option');
        $InputCountnum = $request->input('countnum');

        $Villaoption = trapp_villaoption::create(['villa_fid' => $InputVilla, 'option_fid' => $InputOption, 'count_num' => $InputCountnum, 'deletetime' => -1]);
        return response()->json(['Data' => $Villaoption], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('trapp.villaoption.edit'))
            throw new AccessDeniedHttpException();

        $InputVilla = $request->get('villa');
        $InputOption = $request->get('option');
        $InputCountnum = $request->get('countnum');;


        $Villaoption = new trapp_villaoption();
        $Villaoption = $Villaoption->find($id);
        $Villaoption->villa_fid = $InputVilla;
        $Villaoption->option_fid = $InputOption;
        $Villaoption->count_num = $InputCountnum;
        $Villaoption->save();
        return response()->json(['Data' => $Villaoption], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.villaoption.insert');
        Bouncer::allow('admin')->to('trapp.villaoption.edit');
        Bouncer::allow('admin')->to('trapp.villaoption.list');
        Bouncer::allow('admin')->to('trapp.villaoption.view');
        Bouncer::allow('admin')->to('trapp.villaoption.delete');
        //if(!Bouncer::can('trapp.villaoption.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $VillaoptionQuery = trapp_villaoption::where('id', '>=', '0');
        $VillaoptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaoptionQuery, 'villa_fid', $SearchText);
        $VillaoptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaoptionQuery, 'villa_fid', $request->get('villa'));
        $VillaoptionQuery = SweetQueryBuilder::OrderIfNotNull($VillaoptionQuery, 'villa__sort', 'villa_fid', $request->get('villa__sort'));
        $VillaoptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaoptionQuery, 'option_fid', $request->get('option'));
        $VillaoptionQuery = SweetQueryBuilder::OrderIfNotNull($VillaoptionQuery, 'option__sort', 'option_fid', $request->get('option__sort'));
        $VillaoptionQuery = SweetQueryBuilder::WhereLikeIfNotNull($VillaoptionQuery, 'count_num', $request->get('countnum'));
        $VillaoptionQuery = SweetQueryBuilder::OrderIfNotNull($VillaoptionQuery, 'countnum__sort', 'count_num', $request->get('countnum__sort'));
        $VillaoptionsCount = $VillaoptionQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $VillaoptionsCount], 200);
        $Villaoptions = SweetQueryBuilder::setPaginationIfNotNull($VillaoptionQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $VillaoptionsArray = [];
        for ($i = 0; $i < count($Villaoptions); $i++) {
            $VillaoptionsArray[$i] = $Villaoptions[$i]->toArray();
            $VillaField = $Villaoptions[$i]->villa();
            $VillaoptionsArray[$i]['villacontent'] = $VillaField == null ? '' : $VillaField->name;
            $OptionField = $Villaoptions[$i]->option();
            $VillaoptionsArray[$i]['optioncontent'] = $OptionField == null ? '' : $OptionField->name;
        }
        $Villaoption = $this->getNormalizedList($VillaoptionsArray);
        return response()->json(['Data' => $Villaoption, 'RecordCount' => $VillaoptionsCount], 200);
    }

    public function listVillaOptions($VillaID, Request $request)
    {
        $Options = villaOption::getVillaOptions($VillaID,true);
        $Villaoption = $this->getNormalizedList($Options['data']);
        return response()->json(['Data' => $Villaoption, 'RecordCount' => $Options['count']], 200);
    }


    public function saveVillaOptions($VillaID, Request $request)
    {
        $Villaoptions = trapp_option::getFreeOptions();
        for ($i = 0; $i < count($Villaoptions); $i++) {
            $theOption = $Villaoptions[$i];
            $optionNewValue = $request->get('option' . $theOption->id);
            if ($optionNewValue == '' || !is_numeric($optionNewValue))
                $optionNewValue = 0;

            $oldVillaOption = trapp_villaoption::where('villa_fid', '=', $VillaID)->where('option_fid', '=', $theOption->id)->first();
            if ($oldVillaOption == null) {
                trapp_villaoption::create(['villa_fid' => $VillaID, 'option_fid' => $theOption->id, 'count_num' => $optionNewValue]);
            } else {
                $oldVillaOption->count_num = $optionNewValue;
                $oldVillaOption->save();
            }

        }
        return response()->json(['Data' => [''], 'message' => 'succeed', 'RecordCount' => 0], 200);

    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.villaoption.view'))
        //throw new AccessDeniedHttpException();
        $Villaoption = trapp_villaoption::find($id);
        $VillaoptionObjectAsArray = $Villaoption->toArray();
        $VillaObject = $Villaoption->villa();
        $VillaObject = $VillaObject == null ? '' : $VillaObject;
        $VillaoptionObjectAsArray['villainfo'] = $this->getNormalizedItem($VillaObject->toArray());
        $OptionObject = $Villaoption->option();
        $OptionObject = $OptionObject == null ? '' : $OptionObject;
        $VillaoptionObjectAsArray['optioninfo'] = $this->getNormalizedItem($OptionObject->toArray());
        $Villaoption = $this->getNormalizedItem($VillaoptionObjectAsArray);
        return response()->json(['Data' => $Villaoption], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.villaoption.delete'))
            throw new AccessDeniedHttpException();
        $Villaoption = trapp_villaoption::find($id);
        $Villaoption->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}