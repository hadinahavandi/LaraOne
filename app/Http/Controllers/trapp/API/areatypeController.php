<?php
namespace App\Http\Controllers\trapp\API;
use App\models\trapp\trapp_areatype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\trapp\trapp_areatypeAddRequest;
use App\Http\Requests\trapp\trapp_areatypeUpdateRequest;

class AreatypeController extends SweetController
{
    private $ModuleName = 'trapp';

    public function add(trapp_areatypeAddRequest $request)
    {
        if (!Bouncer::can('trapp.areatype.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();

        $InputName = $request->input('name', ' ');

        $Areatype = trapp_areatype::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Areatype], 201);
    }

    public function update($id, trapp_areatypeUpdateRequest $request)
    {
        if (!Bouncer::can('trapp.areatype.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputName = $request->get('name', ' ');;
            
    
        $Areatype = new trapp_areatype();
        $Areatype = $Areatype->find($id);
        $Areatype->name = $InputName;
        $Areatype->save();
        return response()->json(['Data' => $Areatype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.areatype.insert');
        Bouncer::allow('admin')->to('trapp.areatype.edit');
        Bouncer::allow('admin')->to('trapp.areatype.list');
        Bouncer::allow('admin')->to('trapp.areatype.view');
        Bouncer::allow('admin')->to('trapp.areatype.delete');
        //if(!Bouncer::can('trapp.areatype.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $AreatypeQuery = trapp_areatype::where('id', '>=', '0');
        $AreatypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($AreatypeQuery, 'name', $SearchText);
        $AreatypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($AreatypeQuery, 'name', $request->get('name'));
        $AreatypeQuery = SweetQueryBuilder::OrderIfNotNull($AreatypeQuery, 'name__sort', 'name', $request->get('name__sort'));
        $AreatypesCount = $AreatypeQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $AreatypesCount], 200);
        $Areatypes = SweetQueryBuilder::setPaginationIfNotNull($AreatypeQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $AreatypesArray = [];
        for ($i = 0; $i < count($Areatypes); $i++) {
            $AreatypesArray[$i] = $Areatypes[$i]->toArray();
        }
        $Areatype = $this->getNormalizedList($AreatypesArray);
        return response()->json(['Data' => $Areatype, 'RecordCount' => $AreatypesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.areatype.view'))
        //throw new AccessDeniedHttpException();
        $Areatype = trapp_areatype::find($id);
        $AreatypeObjectAsArray = $Areatype->toArray();
        $Areatype = $this->getNormalizedItem($AreatypeObjectAsArray);
        return response()->json(['Data' => $Areatype], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.areatype.delete'))
            throw new AccessDeniedHttpException();
        $Areatype = trapp_areatype::find($id);
        $Areatype->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}