<?php
namespace App\Http\Controllers\carserviceorder\API;
use App\models\carserviceorder\carserviceorder_carmaker;
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
use App\Http\Requests\carserviceorder\carserviceorder_carmakerAddRequest;
use App\Http\Requests\carserviceorder\carserviceorder_carmakerUpdateRequest;

class CarmakerController extends SweetController
{
    private $ModuleName='carserviceorder';

	public function add(carserviceorder_carmakerAddRequest $request)
    {
        if(!Bouncer::can('carserviceorder.carmaker.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputTitle=$request->input('title',' ');
    
		$Carmaker = carserviceorder_carmaker::create(['title'=>$InputTitle,'deletetime'=>-1]);
		$InputLogoiguPath=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'carmaker','logoigu',$Carmaker->id,'jpg');
        $Carmaker->logo_igu=$InputLogoiguPath->uploadFromRequest($request->file('logoigu'));
		$Carmaker->save();
		return response()->json(['Data'=>$Carmaker], 201);
	}
	public function update($id,carserviceorder_carmakerUpdateRequest $request)
    {
        if(!Bouncer::can('carserviceorder.carmaker.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputTitle=$request->get('title',' ');;
            
    
        $Carmaker = new carserviceorder_carmaker();
        $Carmaker = $Carmaker->find($id);
        $Carmaker->title=$InputTitle;
		$InputLogoiguPath=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'carmaker','logoigu',$Carmaker->id,'jpg');
        if($InputLogoiguPath!=null)
            $Carmaker->logo_igu=$InputLogoiguPath->uploadFromRequest($request->file('logoigu'));
        $Carmaker->save();
        return response()->json(['Data'=>$Carmaker], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('carserviceorder.carmaker.insert');
        Bouncer::allow('admin')->to('carserviceorder.carmaker.edit');
        Bouncer::allow('admin')->to('carserviceorder.carmaker.list');
        Bouncer::allow('admin')->to('carserviceorder.carmaker.view');
        Bouncer::allow('admin')->to('carserviceorder.carmaker.delete');
        //if(!Bouncer::can('carserviceorder.carmaker.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $CarmakerQuery = carserviceorder_carmaker::where('id','>=','0');
        $CarmakerQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarmakerQuery,'title',$SearchText);
        $CarmakerQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarmakerQuery,'title',$request->get('title'));
        $CarmakerQuery =SweetQueryBuilder::OrderIfNotNull($CarmakerQuery,'title__sort','title',$request->get('title__sort'));
        $CarmakersCount=$CarmakerQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$CarmakersCount], 200);
        $Carmakers=SweetQueryBuilder::setPaginationIfNotNull($CarmakerQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $CarmakersArray=[];
        for($i=0;$i<count($Carmakers);$i++)
        {
            $CarmakersArray[$i]=$Carmakers[$i]->toArray();
        }
        $Carmaker = $this->getNormalizedList($CarmakersArray);
        return response()->json(['Data'=>$Carmaker,'RecordCount'=>$CarmakersCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('carserviceorder.carmaker.view'))
            //throw new AccessDeniedHttpException();
        $Carmaker=carserviceorder_carmaker::find($id);
        $CarmakerObjectAsArray=$Carmaker->toArray();
        $Carmaker = $this->getNormalizedItem($CarmakerObjectAsArray);
        return response()->json(['Data'=>$Carmaker], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('carserviceorder.carmaker.delete'))
            throw new AccessDeniedHttpException();
        $Carmaker = carserviceorder_carmaker::find($id);
        $Carmaker->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}