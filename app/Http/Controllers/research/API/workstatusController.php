<?php
namespace App\Http\Controllers\research\API;
use App\models\research\research_workstatus;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\research\workstatus\research_workstatusAddRequest;
use App\Http\Requests\research\workstatus\research_workstatusUpdateRequest;
use App\Http\Requests\research\workstatus\research_workstatusListRequest;

class WorkstatusController extends SweetController
{
    private $ModuleName='research';

	public function add(research_workstatusAddRequest $request)
    {
        //if(!Bouncer::can('research.workstatus.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Workstatus = new research_workstatus();
        $Workstatus->name=$request->getName();
		$Workstatus->deletetime= -1;
		$Workstatus->save();
		return response()->json(['Data'=>$Workstatus], 201);
	}
	public function update($id,research_workstatusUpdateRequest $request)
    {
        if(!Bouncer::can('research.workstatus.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Workstatus = new research_workstatus();
        $Workstatus = research_workstatus::find($id);
        $Workstatus->name=$request->getName();
        $Workstatus->save();
        return response()->json(['Data'=>$Workstatus], 202);
    }
    public function list(research_workstatusListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('research.workstatus.insert');
        Bouncer::allow('admin')->to('research.workstatus.edit');
        Bouncer::allow('admin')->to('research.workstatus.list');
        Bouncer::allow('admin')->to('research.workstatus.view');
        Bouncer::allow('admin')->to('research.workstatus.delete');
        */
        //if(!Bouncer::can('research.workstatus.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $WorkstatusQuery = research_workstatus::where('id','>=','0');
        $WorkstatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($WorkstatusQuery,'name',$SearchText);
        $WorkstatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($WorkstatusQuery,'name',$request->get('name'));
        $WorkstatusQuery = SweetQueryBuilder::orderByFields($WorkstatusQuery, $request->getOrderFields());
        $WorkstatussCount=$WorkstatusQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$WorkstatussCount], 200);
        $Workstatuss=SweetQueryBuilder::setPaginationIfNotNull($WorkstatusQuery,$request->getStartRow(),$request->getPageSize())->get();
        $WorkstatussArray=[];
        for($i=0;$i<count($Workstatuss);$i++)
        {
            $WorkstatussArray[$i]=$Workstatuss[$i]->toArray();
        }
        $Workstatus = $this->getNormalizedList($WorkstatussArray);
        return response()->json(['Data'=>$Workstatus,'RecordCount'=>$WorkstatussCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('research.workstatus.view'))
            //throw new AccessDeniedHttpException();
        $Workstatus=research_workstatus::find($id);
        $WorkstatusObjectAsArray=$Workstatus->toArray();
        $Workstatus = $this->getNormalizedItem($WorkstatusObjectAsArray);
        return response()->json(['Data'=>$Workstatus], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('research.workstatus.delete'))
            throw new AccessDeniedHttpException();
        $Workstatus = research_workstatus::find($id);
        $Workstatus->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}