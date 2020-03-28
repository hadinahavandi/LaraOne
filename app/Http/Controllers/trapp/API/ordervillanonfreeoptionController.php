<?php
namespace App\Http\Controllers\trapp\API;
use App\models\trapp\trapp_ordervillanonfreeoption;
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
use App\Http\Requests\trapp\trapp_ordervillanonfreeoptionAddRequest;
use App\Http\Requests\trapp\trapp_ordervillanonfreeoptionUpdateRequest;

class OrdervillanonfreeoptionController extends SweetController
{
    private $ModuleName='trapp';

	public function add(trapp_ordervillanonfreeoptionAddRequest $request)
    {
        if(!Bouncer::can('trapp.ordervillanonfreeoption.insert'))
            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputOrder=$request->input('order',-1);
		$InputVillanonfreeoption=$request->input('villanonfreeoption',-1);
		$InputCountnum=$request->input('countnum',0);
		$InputPricenum=$request->input('pricenum',0);
    
		$Ordervillanonfreeoption = trapp_ordervillanonfreeoption::create(['order_fid'=>$InputOrder,'villanonfreeoption_fid'=>$InputVillanonfreeoption,'count_num'=>$InputCountnum,'price_num'=>$InputPricenum,'deletetime'=>-1]);
		return response()->json(['Data'=>$Ordervillanonfreeoption], 201);
	}
	public function update($id,trapp_ordervillanonfreeoptionUpdateRequest $request)
    {
        if(!Bouncer::can('trapp.ordervillanonfreeoption.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputOrder=$request->get('order',-1);
		$InputVillanonfreeoption=$request->get('villanonfreeoption',-1);
		$InputCountnum=$request->get('countnum',0);
		$InputPricenum=$request->get('pricenum',0);;
            
    
        $Ordervillanonfreeoption = new trapp_ordervillanonfreeoption();
        $Ordervillanonfreeoption = $Ordervillanonfreeoption->find($id);
        $Ordervillanonfreeoption->order_fid=$InputOrder;
        $Ordervillanonfreeoption->villanonfreeoption_fid=$InputVillanonfreeoption;
        $Ordervillanonfreeoption->count_num=$InputCountnum;
        $Ordervillanonfreeoption->price_num=$InputPricenum;
        $Ordervillanonfreeoption->save();
        return response()->json(['Data'=>$Ordervillanonfreeoption], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.ordervillanonfreeoption.insert');
        Bouncer::allow('admin')->to('trapp.ordervillanonfreeoption.edit');
        Bouncer::allow('admin')->to('trapp.ordervillanonfreeoption.list');
        Bouncer::allow('admin')->to('trapp.ordervillanonfreeoption.view');
        Bouncer::allow('admin')->to('trapp.ordervillanonfreeoption.delete');
        //if(!Bouncer::can('trapp.ordervillanonfreeoption.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $OrdervillanonfreeoptionQuery = trapp_ordervillanonfreeoption::where('id','>=','0');
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($OrdervillanonfreeoptionQuery,'order_fid',$SearchText);
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($OrdervillanonfreeoptionQuery,'order_fid',$request->get('order'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($OrdervillanonfreeoptionQuery,'order__sort','order_fid',$request->get('order__sort'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($OrdervillanonfreeoptionQuery,'villanonfreeoption_fid',$request->get('villanonfreeoption'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($OrdervillanonfreeoptionQuery,'villanonfreeoption__sort','villanonfreeoption_fid',$request->get('villanonfreeoption__sort'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($OrdervillanonfreeoptionQuery,'count_num',$request->get('countnum'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($OrdervillanonfreeoptionQuery,'countnum__sort','count_num',$request->get('countnum__sort'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($OrdervillanonfreeoptionQuery,'price_num',$request->get('pricenum'));
        $OrdervillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($OrdervillanonfreeoptionQuery,'pricenum__sort','price_num',$request->get('pricenum__sort'));
        $OrdervillanonfreeoptionsCount=$OrdervillanonfreeoptionQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$OrdervillanonfreeoptionsCount], 200);
        $Ordervillanonfreeoptions=SweetQueryBuilder::setPaginationIfNotNull($OrdervillanonfreeoptionQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $OrdervillanonfreeoptionsArray=[];
        for($i=0;$i<count($Ordervillanonfreeoptions);$i++)
        {
            $OrdervillanonfreeoptionsArray[$i]=$Ordervillanonfreeoptions[$i]->toArray();
            $OrderField=$Ordervillanonfreeoptions[$i]->order();
            $OrdervillanonfreeoptionsArray[$i]['ordercontent']=$OrderField==null?'':$OrderField->name;
            $VillanonfreeoptionField=$Ordervillanonfreeoptions[$i]->villanonfreeoption();
            $OrdervillanonfreeoptionsArray[$i]['villanonfreeoptioncontent']=$VillanonfreeoptionField==null?'':$VillanonfreeoptionField->name;
        }
        $Ordervillanonfreeoption = $this->getNormalizedList($OrdervillanonfreeoptionsArray);
        return response()->json(['Data'=>$Ordervillanonfreeoption,'RecordCount'=>$OrdervillanonfreeoptionsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('trapp.ordervillanonfreeoption.view'))
            //throw new AccessDeniedHttpException();
        $Ordervillanonfreeoption=trapp_ordervillanonfreeoption::find($id);
        $OrdervillanonfreeoptionObjectAsArray=$Ordervillanonfreeoption->toArray();
        $OrderObject=$Ordervillanonfreeoption->order();
        $OrderObject=$OrderObject==null?'':$OrderObject;
        $OrdervillanonfreeoptionObjectAsArray['orderinfo']=$this->getNormalizedItem($OrderObject->toArray());
        $VillanonfreeoptionObject=$Ordervillanonfreeoption->villanonfreeoption();
        $VillanonfreeoptionObject=$VillanonfreeoptionObject==null?'':$VillanonfreeoptionObject;
        $OrdervillanonfreeoptionObjectAsArray['villanonfreeoptioninfo']=$this->getNormalizedItem($VillanonfreeoptionObject->toArray());
        $Ordervillanonfreeoption = $this->getNormalizedItem($OrdervillanonfreeoptionObjectAsArray);
        return response()->json(['Data'=>$Ordervillanonfreeoption], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('trapp.ordervillanonfreeoption.delete'))
            throw new AccessDeniedHttpException();
        $Ordervillanonfreeoption = trapp_ordervillanonfreeoption::find($id);
        $Ordervillanonfreeoption->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}