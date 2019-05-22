<?php
namespace App\Http\Controllers\sas\API;
use App\models\sas\sas_status;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StatusController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.status.insert'))
            throw new AccessDeniedHttpException();
    
		$InputName=$request->input('name');
		$InputPriority=$request->input('priority');
		$InputCommited=$request->input('commited');
		$InputSuccessful=$request->input('successful');
		$Status = sas_status::create(['name'=>$InputName,'priority'=>$InputPriority,'is_commited'=>$InputCommited,'is_successful'=>$InputSuccessful,'deletetime'=>-1]);
		return response()->json(['Data'=>$Status], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.status.edit'))
            throw new AccessDeniedHttpException();
    
        $InputName=$request->get('name');
        $InputPriority=$request->get('priority');
        $InputCommited=$request->get('commited');
        $InputSuccessful=$request->get('successful');
        $Status = new sas_status();
        $Status = $Status->find($id);
        $Status->name=$InputName;
        $Status->priority=$InputPriority;
        $Status->is_commited=$InputCommited;
        $Status->is_successful=$InputSuccessful;
        $Status->save();
        return response()->json(['Data'=>$Status], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.status.insert');
        Bouncer::allow('admin')->to('sas.status.edit');
        Bouncer::allow('admin')->to('sas.status.list');
        Bouncer::allow('admin')->to('sas.status.view');
        Bouncer::allow('admin')->to('sas.status.delete');
        //if(!Bouncer::can('sas.status.list'))
            //throw new AccessDeniedHttpException();
        $StatusQuery = sas_status::where('id','>=','0');
        $StatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($StatusQuery,'name',$request->get('name'));
        $StatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($StatusQuery,'priority',$request->get('priority'));
        $StatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($StatusQuery,'is_commited',$request->get('commited'));
        $StatusQuery =SweetQueryBuilder::WhereLikeIfNotNull($StatusQuery,'is_successful',$request->get('successful'));
        $Statuss=$StatusQuery->get();
        $StatussArray=[];
        for($i=0;$i<count($Statuss);$i++)
        {
            $StatussArray[$i]=$Statuss[$i]->toArray();
        }
        $Status = $this->getNormalizedList($StatussArray);
        return response()->json(['Data'=>$Status,'RecordCount'=>count($Status)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.status.view'))
            //throw new AccessDeniedHttpException();
        $Status = $this->getNormalizedItem(sas_status::find($id)->toArray());
        return response()->json(['Data'=>$Status], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.status.delete'))
            throw new AccessDeniedHttpException();
        $Status = sas_status::find($id);
        $Status->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}