<?php
namespace App\Http\Controllers\trapp\API;
use App\models\trapp\trapp_viewtype;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\trapp\trapp_viewtypeAddRequest;
use App\Http\Requests\trapp\trapp_viewtypeUpdateRequest;

class ViewtypeController extends SweetController
{
    private $ModuleName = 'trapp';

    public function add(trapp_viewtypeAddRequest $request)
    {
        if (!Bouncer::can('trapp.viewtype.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();

        $InputName = $request->input('name', ' ');

        $Viewtype = trapp_viewtype::create(['name' => $InputName, 'deletetime' => -1]);
        return response()->json(['Data' => $Viewtype], 201);
    }

    public function update($id, trapp_viewtypeUpdateRequest $request)
    {
        if (!Bouncer::can('trapp.viewtype.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();

        $InputName = $request->get('name', ' ');;
            
    
        $Viewtype = new trapp_viewtype();
        $Viewtype = $Viewtype->find($id);
        $Viewtype->name = $InputName;
        $Viewtype->save();
        return response()->json(['Data' => $Viewtype], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.viewtype.insert');
        Bouncer::allow('admin')->to('trapp.viewtype.edit');
        Bouncer::allow('admin')->to('trapp.viewtype.list');
        Bouncer::allow('admin')->to('trapp.viewtype.view');
        Bouncer::allow('admin')->to('trapp.viewtype.delete');
        //if(!Bouncer::can('trapp.viewtype.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $ViewtypeQuery = trapp_viewtype::where('id', '>=', '0');
        $ViewtypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($ViewtypeQuery, 'name', $SearchText);
        $ViewtypeQuery = SweetQueryBuilder::WhereLikeIfNotNull($ViewtypeQuery, 'name', $request->get('name'));
        $ViewtypeQuery = SweetQueryBuilder::OrderIfNotNull($ViewtypeQuery, 'name__sort', 'name', $request->get('name__sort'));
        $ViewtypesCount = $ViewtypeQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $ViewtypesCount], 200);
        $Viewtypes = SweetQueryBuilder::setPaginationIfNotNull($ViewtypeQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $ViewtypesArray = [];
        for ($i = 0; $i < count($Viewtypes); $i++) {
            $ViewtypesArray[$i] = $Viewtypes[$i]->toArray();
        }
        $Viewtype = $this->getNormalizedList($ViewtypesArray);
        return response()->json(['Data' => $Viewtype, 'RecordCount' => $ViewtypesCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('trapp.viewtype.view'))
        //throw new AccessDeniedHttpException();
        $Viewtype = trapp_viewtype::find($id);
        $ViewtypeObjectAsArray = $Viewtype->toArray();
        $Viewtype = $this->getNormalizedItem($ViewtypeObjectAsArray);
        return response()->json(['Data' => $Viewtype], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('trapp.viewtype.delete'))
            throw new AccessDeniedHttpException();
        $Viewtype = trapp_viewtype::find($id);
        $Viewtype->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}