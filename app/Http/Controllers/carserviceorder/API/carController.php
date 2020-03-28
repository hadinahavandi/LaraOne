<?php
namespace App\Http\Controllers\carserviceorder\API;
use App\models\carserviceorder\carserviceorder_car;
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
use App\Http\Requests\carserviceorder\carserviceorder_carAddRequest;
use App\Http\Requests\carserviceorder\carserviceorder_carUpdateRequest;

class CarController extends SweetController
{
    private $ModuleName='carserviceorder';

	public function add(carserviceorder_carAddRequest $request)
    {
        if(!Bouncer::can('carserviceorder.car.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputTitle=$request->input('title',' ');
		$InputMaxmodelnum=$request->input('maxmodelnum',0);
		$InputMinmodelnum=$request->input('minmodelnum',0);
		$InputCarmaker=$request->input('carmaker',-1);
    
		$Car = carserviceorder_car::create(['title'=>$InputTitle,'maxmodel_num'=>$InputMaxmodelnum,'minmodel_num'=>$InputMinmodelnum,'carmaker_fid'=>$InputCarmaker,'deletetime'=>-1]);
		$InputPhotoiguPath=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'car','photoigu',$Car->id,'jpg');
        $Car->photo_igu=$InputPhotoiguPath->uploadFromRequest($request->file('photoigu'));
		$Car->save();
		return response()->json(['Data'=>$Car], 201);
	}
	public function update($id,carserviceorder_carUpdateRequest $request)
    {
        if(!Bouncer::can('carserviceorder.car.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputTitle=$request->get('title',' ');
		$InputMaxmodelnum=$request->get('maxmodelnum',0);
		$InputMinmodelnum=$request->get('minmodelnum',0);
		$InputCarmaker=$request->get('carmaker',-1);;
            
    
        $Car = new carserviceorder_car();
        $Car = $Car->find($id);
        $Car->title=$InputTitle;
        $Car->maxmodel_num=$InputMaxmodelnum;
        $Car->minmodel_num=$InputMinmodelnum;
        $Car->carmaker_fid=$InputCarmaker;
		$InputPhotoiguPath=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'car','photoigu',$Car->id,'jpg');
        if($InputPhotoiguPath!=null)
            $Car->photo_igu=$InputPhotoiguPath->uploadFromRequest($request->file('photoigu'));
        $Car->save();
        return response()->json(['Data'=>$Car], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('carserviceorder.car.insert');
        Bouncer::allow('admin')->to('carserviceorder.car.edit');
        Bouncer::allow('admin')->to('carserviceorder.car.list');
        Bouncer::allow('admin')->to('carserviceorder.car.view');
        Bouncer::allow('admin')->to('carserviceorder.car.delete');
        //if(!Bouncer::can('carserviceorder.car.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $CarQuery = carserviceorder_car::where('id','>=','0');
        $CarQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarQuery,'title',$SearchText);
        $CarQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarQuery,'title',$request->get('title'));
        $CarQuery =SweetQueryBuilder::OrderIfNotNull($CarQuery,'title__sort','title',$request->get('title__sort'));
        $CarQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarQuery,'maxmodel_num',$request->get('maxmodelnum'));
        $CarQuery =SweetQueryBuilder::OrderIfNotNull($CarQuery,'maxmodelnum__sort','maxmodel_num',$request->get('maxmodelnum__sort'));
        $CarQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarQuery,'minmodel_num',$request->get('minmodelnum'));
        $CarQuery =SweetQueryBuilder::OrderIfNotNull($CarQuery,'minmodelnum__sort','minmodel_num',$request->get('minmodelnum__sort'));
        $CarQuery =SweetQueryBuilder::WhereLikeIfNotNull($CarQuery,'carmaker_fid',$request->get('carmaker'));
        $CarQuery =SweetQueryBuilder::OrderIfNotNull($CarQuery,'carmaker__sort','carmaker_fid',$request->get('carmaker__sort'));
        $CarsCount=$CarQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$CarsCount], 200);
        $Cars=SweetQueryBuilder::setPaginationIfNotNull($CarQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $CarsArray=[];
        for($i=0;$i<count($Cars);$i++)
        {
            $CarsArray[$i]=$Cars[$i]->toArray();
            $CarmakerField=$Cars[$i]->carmaker();
            $CarsArray[$i]['carmakercontent']=$CarmakerField==null?'':$CarmakerField->name;
        }
        $Car = $this->getNormalizedList($CarsArray);
        return response()->json(['Data'=>$Car,'RecordCount'=>$CarsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('carserviceorder.car.view'))
            //throw new AccessDeniedHttpException();
        $Car=carserviceorder_car::find($id);
        $CarObjectAsArray=$Car->toArray();
        $CarmakerObject=$Car->carmaker();
        $CarmakerObject=$CarmakerObject==null?'':$CarmakerObject;
        $CarObjectAsArray['carmakerinfo']=$this->getNormalizedItem($CarmakerObject->toArray());
        $Car = $this->getNormalizedItem($CarObjectAsArray);
        return response()->json(['Data'=>$Car], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('carserviceorder.car.delete'))
            throw new AccessDeniedHttpException();
        $Car = carserviceorder_car::find($id);
        $Car->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}