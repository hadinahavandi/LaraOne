<?php
namespace App\Http\Controllers\sas\API;
use App\Http\Controllers\sas\Classes\Unit;
use App\models\sas\sas_unit;
use App\models\sas\sas_unitsequence;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnitsequenceController extends SweetController
{

	public function add(Request $request)
    {
        if(!Bouncer::can('sas.unitsequence.insert'))
            throw new AccessDeniedHttpException();
    
		$InputSourceunit=$request->input('sourceunit');
		$InputDestinationunit=$request->input('destinationunit');
		$Unitsequence = sas_unitsequence::create(['source__unit_fid'=>$InputSourceunit,'destination__unit_fid'=>$InputDestinationunit,'deletetime'=>-1]);
		return response()->json(['Data'=>$Unitsequence], 201);
	}
	public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.unitsequence.edit'))
            throw new AccessDeniedHttpException();
    
        $InputSourceunit=$request->get('sourceunit');
        $InputDestinationunit=$request->get('destinationunit');
        $Unitsequence = new sas_unitsequence();
        $Unitsequence = $Unitsequence->find($id);
        $Unitsequence->source__unit_fid=$InputSourceunit;
        $Unitsequence->destination__unit_fid=$InputDestinationunit;
        $Unitsequence->save();
        return response()->json(['Data'=>$Unitsequence], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.unitsequence.insert');
        Bouncer::allow('admin')->to('sas.unitsequence.edit');
        Bouncer::allow('admin')->to('sas.unitsequence.list');
        Bouncer::allow('admin')->to('sas.unitsequence.view');
        Bouncer::allow('admin')->to('sas.unitsequence.delete');
        //if(!Bouncer::can('sas.unitsequence.list'))
            //throw new AccessDeniedHttpException();
        $UnitsequenceQuery = sas_unitsequence::where('id','>=','0');
        $UnitsequenceQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitsequenceQuery,'source__unit_fid',$request->get('sourceunit'));
        $UnitsequenceQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitsequenceQuery,'destination__unit_fid',$request->get('destinationunit'));
        $Unitsequences=$UnitsequenceQuery->get();
        $UnitsequencesArray=[];
        for($i=0;$i<count($Unitsequences);$i++)
        {
            $UnitsequencesArray[$i]=$Unitsequences[$i]->toArray();
            $SourceunitField=$Unitsequences[$i]->sourceunit();
            $UnitsequencesArray[$i]['sourceunitcontent']=$SourceunitField==null?'':$SourceunitField->name;
            $DestinationunitField=$Unitsequences[$i]->destinationunit();
            $UnitsequencesArray[$i]['destinationunitcontent']=$DestinationunitField==null?'':$DestinationunitField->name;
        }
        $Unitsequence = $this->getNormalizedList($UnitsequencesArray);
        return response()->json(['Data'=>$Unitsequence,'RecordCount'=>count($Unitsequence)], 200);
    }
    public function userunits(Request $request)
    {
        Bouncer::allow('admin')->to('sas.unitsequence.insert');
        Bouncer::allow('admin')->to('sas.unitsequence.edit');
        Bouncer::allow('admin')->to('sas.unitsequence.list');
        Bouncer::allow('admin')->to('sas.unitsequence.view');
        Bouncer::allow('admin')->to('sas.unitsequence.delete');
        //if(!Bouncer::can('sas.unitsequence.list'))
            //throw new AccessDeniedHttpException();
        $Unitsequences = Unit::getUserNextUnits();
        $UnitsequencesArray=[];
        for($i=0;$i<count($Unitsequences);$i++)
        {
            $UnitsequencesArray[$i]=$Unitsequences[$i]->toArray();
            $DestinationunitField=$Unitsequences[$i]->destinationunit();
            $UnitsequencesArray[$i]['destinationunitcontent']=$DestinationunitField==null?'':$DestinationunitField->name;
        }
        $Unitsequence = $this->getNormalizedList($UnitsequencesArray);
        return response()->json(['Data'=>$Unitsequence,'RecordCount'=>count($Unitsequence)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.unitsequence.view'))
            //throw new AccessDeniedHttpException();
        $Unitsequence = $this->getNormalizedItem(sas_unitsequence::find($id)->toArray());
        return response()->json(['Data'=>$Unitsequence], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.unitsequence.delete'))
            throw new AccessDeniedHttpException();
        $Unitsequence = sas_unitsequence::find($id);
        $Unitsequence->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}