<?php
namespace App\Http\Controllers\trapp\API;
use App\Http\Controllers\trapp\classes\villaOption;
use App\models\trapp\trapp_option;
use App\models\trapp\trapp_villanonfreeoption;
use App\Http\Controllers\Controller;
use App\models\trapp\trapp_villaoption;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\trapp\trapp_villanonfreeoptionAddRequest;
use App\Http\Requests\trapp\trapp_villanonfreeoptionUpdateRequest;

class VillanonfreeoptionController extends SweetController
{
    private $ModuleName='trapp';
    public function listVillaNonFreeOptions($VillaID,Request $request)
    {
        $Options = villaOption::getVillaOptions($VillaID,false);
        $Villaoption = $this->getNormalizedList($Options['data']);
        return response()->json(['Data' => $Villaoption, 'RecordCount' => $Options['count']], 200);

    }

    public function saveVillaOptions($VillaID, Request $request)
    {
        $Villaoptions = trapp_option::getNonFreeOptions();
        for ($i = 0; $i < count($Villaoptions); $i++) {
            $theOption = $Villaoptions[$i];
            $optionNewPrice = $request->get('optionprice' . $theOption->id);
            $optionNewMaxCount = $request->get('optionmaxcount' . $theOption->id);
            $oldVillaOption = trapp_villanonfreeoption::where('villa_fid', '=', $VillaID)->where('option_fid', '=', $theOption->id)->first();

                if ($optionNewPrice == '' || !is_numeric($optionNewPrice))
                    $optionNewPrice = 0;

                if ($optionNewMaxCount == '' || !is_numeric($optionNewMaxCount))
                    $optionNewMaxCount = 0;
                if ($oldVillaOption == null) {
                    trapp_villanonfreeoption::create(['villa_fid' => $VillaID, 'option_fid' => $theOption->id,'maxcount_num' =>$optionNewMaxCount,'price_num' => $optionNewPrice]);
                } else {
                    $oldVillaOption->maxcount_num =$optionNewMaxCount;
                    $oldVillaOption->price_num = $optionNewPrice;
                    $oldVillaOption->save();
                }



        }
        return response()->json(['Data' => [''], 'message' => 'succeed', 'RecordCount' => 0], 200);

    }
	public function add(trapp_villanonfreeoptionAddRequest $request)
    {
//        if(!Bouncer::can('trapp.villanonfreeoption.insert'))
//            throw new AccessDeniedHttpException();
        $request->validated();
        
		$InputVilla=$request->input('villa',-1);
		$InputOption=$request->input('option',-1);
		$InputOptional=$request->input('optional',' ');
		$InputPricenum=$request->input('pricenum',0);
		$InputMaxcountnum=$request->input('maxcountnum',0);
    
		$Villanonfreeoption = trapp_villanonfreeoption::create(['villa_fid'=>$InputVilla,'option_fid'=>$InputOption,'is_optional'=>$InputOptional,'price_num'=>$InputPricenum,'maxcount_num'=>$InputMaxcountnum,'deletetime'=>-1]);
		return response()->json(['Data'=>$Villanonfreeoption], 201);
	}
	public function update($id,trapp_villanonfreeoptionUpdateRequest $request)
    {
//        if(!Bouncer::can('trapp.villanonfreeoption.edit'))
//            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
        
		$InputVilla=$request->get('villa',-1);
		$InputOption=$request->get('option',-1);
		$InputOptional=$request->get('optional',' ');
		$InputPricenum=$request->get('pricenum',0);
		$InputMaxcountnum=$request->get('maxcountnum',0);;
            
    
        $Villanonfreeoption = new trapp_villanonfreeoption();
        $Villanonfreeoption = $Villanonfreeoption->find($id);
        $Villanonfreeoption->villa_fid=$InputVilla;
        $Villanonfreeoption->option_fid=$InputOption;
        $Villanonfreeoption->is_optional=$InputOptional;
        $Villanonfreeoption->price_num=$InputPricenum;
        $Villanonfreeoption->maxcount_num=$InputMaxcountnum;
        $Villanonfreeoption->save();
        return response()->json(['Data'=>$Villanonfreeoption], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('trapp.villanonfreeoption.insert');
        Bouncer::allow('admin')->to('trapp.villanonfreeoption.edit');
        Bouncer::allow('admin')->to('trapp.villanonfreeoption.list');
        Bouncer::allow('admin')->to('trapp.villanonfreeoption.view');
        Bouncer::allow('admin')->to('trapp.villanonfreeoption.delete');
        //if(!Bouncer::can('trapp.villanonfreeoption.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $VillanonfreeoptionQuery = trapp_villanonfreeoption::where('id','>=','0');
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'villa_fid',$SearchText);
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'villa_fid',$request->get('villa'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($VillanonfreeoptionQuery,'villa__sort','villa_fid',$request->get('villa__sort'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'option_fid',$request->get('option'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($VillanonfreeoptionQuery,'option__sort','option_fid',$request->get('option__sort'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'is_optional',$request->get('optional'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($VillanonfreeoptionQuery,'optional__sort','is_optional',$request->get('optional__sort'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'price_num',$request->get('pricenum'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($VillanonfreeoptionQuery,'pricenum__sort','price_num',$request->get('pricenum__sort'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::WhereLikeIfNotNull($VillanonfreeoptionQuery,'maxcount_num',$request->get('maxcountnum'));
        $VillanonfreeoptionQuery =SweetQueryBuilder::OrderIfNotNull($VillanonfreeoptionQuery,'maxcountnum__sort','maxcount_num',$request->get('maxcountnum__sort'));
        $VillanonfreeoptionsCount=$VillanonfreeoptionQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$VillanonfreeoptionsCount], 200);
        $Villanonfreeoptions=SweetQueryBuilder::setPaginationIfNotNull($VillanonfreeoptionQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $VillanonfreeoptionsArray=[];
        for($i=0;$i<count($Villanonfreeoptions);$i++)
        {
            $VillanonfreeoptionsArray[$i]=$Villanonfreeoptions[$i]->toArray();
            $VillaField=$Villanonfreeoptions[$i]->villa();
            $VillanonfreeoptionsArray[$i]['villacontent']=$VillaField==null?'':$VillaField->name;
            $OptionField=$Villanonfreeoptions[$i]->option();
            $VillanonfreeoptionsArray[$i]['optioncontent']=$OptionField==null?'':$OptionField->name;
        }
        $Villanonfreeoption = $this->getNormalizedList($VillanonfreeoptionsArray);
        return response()->json(['Data'=>$Villanonfreeoption,'RecordCount'=>$VillanonfreeoptionsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('trapp.villanonfreeoption.view'))
            //throw new AccessDeniedHttpException();
        $Villanonfreeoption=trapp_villanonfreeoption::find($id);
        $VillanonfreeoptionObjectAsArray=$Villanonfreeoption->toArray();
        $VillaObject=$Villanonfreeoption->villa();
        $VillaObject=$VillaObject==null?'':$VillaObject;
        $VillanonfreeoptionObjectAsArray['villainfo']=$this->getNormalizedItem($VillaObject->toArray());
        $OptionObject=$Villanonfreeoption->option();
        $OptionObject=$OptionObject==null?'':$OptionObject;
        $VillanonfreeoptionObjectAsArray['optioninfo']=$this->getNormalizedItem($OptionObject->toArray());
        $Villanonfreeoption = $this->getNormalizedItem($VillanonfreeoptionObjectAsArray);
        return response()->json(['Data'=>$Villanonfreeoption], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('trapp.villanonfreeoption.delete'))
            throw new AccessDeniedHttpException();
        $Villanonfreeoption = trapp_villanonfreeoption::find($id);
        $Villanonfreeoption->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}