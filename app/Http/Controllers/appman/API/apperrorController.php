<?php
namespace App\Http\Controllers\appman\API;
use App\models\appman\appman_apperror;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\appman\appman_apperrorAddRequest;
use App\Http\Requests\appman\appman_apperrorUpdateRequest;

class ApperrorController extends SweetController
{
    private $ModuleName='appman';

	public function add(appman_apperrorAddRequest $request)
    {
//        if(!Bouncer::can('appman.apperror.insert'))
//            throw new AccessDeniedHttpException();
        $request->validated();
        $userId=-1;
        try{

            $user=Auth::user();
            if($user!=null)
                $userId=$user->getAuthIdentifier();
        }
        catch (Exception $ex){}
		$InputType=$request->input('type',' ');
		$InputUrl=$request->input('url',' ');
		$InputMethod=$request->input('method',' ');
		$InputPostingdata=$request->input('postingdata',' ');
		$InputReceiveddata=$request->input('receiveddata',' ');
		$InputError=$request->input('error',' ');
		$InputLinenum=$request->input('linenum',0);
		$InputAppname=$request->input('appname',' ');
        $InputAppVersion=$request->input('appversion',' ');
		$InputDeviceBrand=$request->input('devicebrand',' ');
        $InputDeviceModel=$request->input('devicemodel',' ');
        $InputDeviceOS=$request->input('deviceos',' ');
        $InputDeviceOSVersion=$request->input('deviceosversion',' ');

		$Apperror = new appman_apperror();
		$Apperror->type=$InputType;
		$Apperror->url=$InputUrl;
		$Apperror->method=$InputMethod;
		$Apperror->postingdata=$InputPostingdata;
		$Apperror->receiveddata=$InputReceiveddata;
		$Apperror->error=$InputError;
		$Apperror->line_num=$InputLinenum;
		$Apperror->appname=$InputAppname;
		$Apperror->appversion=$InputAppVersion;
		$Apperror->devicebrand=$InputDeviceBrand;
		$Apperror->devicemodel=$InputDeviceModel;
		$Apperror->deviceos=$InputDeviceOS;
		$Apperror->deviceosversion=$InputDeviceOSVersion;
		if($userId>0)
		$Apperror->user_fid=$userId;

		$Apperror->save();
		return response()->json(['Data'=>$Apperror], 201);
	}

    public function list(Request $request)
    {
        Bouncer::allow('developer')->to('appman.apperror.insert');
        Bouncer::allow('developer')->to('appman.apperror.list');
        Bouncer::allow('developer')->to('appman.apperror.view');
        Bouncer::allow('developer')->to('appman.apperror.delete');
        //if(!Bouncer::can('appman.apperror.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $ApperrorQuery = appman_apperror::where('id','>=','0');
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'type',$SearchText);
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'type',$request->get('type'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'type__sort','type',$request->get('type__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'url',$request->get('url'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'url__sort','url',$request->get('url__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'method',$request->get('method'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'method__sort','method',$request->get('method__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'postingdata',$request->get('postingdata'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'postingdata__sort','postingdata',$request->get('postingdata__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'receiveddata',$request->get('receiveddata'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'receiveddata__sort','receiveddata',$request->get('receiveddata__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'error',$request->get('error'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'error__sort','error',$request->get('error__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'line_num',$request->get('linenum'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'linenum__sort','line_num',$request->get('linenum__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'appname',$request->get('appname'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'appname__sort','appname',$request->get('appname__sort'));
        $ApperrorQuery =SweetQueryBuilder::WhereLikeIfNotNull($ApperrorQuery,'user_fid',$request->get('user'));
        $ApperrorQuery =SweetQueryBuilder::OrderIfNotNull($ApperrorQuery,'user__sort','user_fid',$request->get('user__sort'));
        $ApperrorsCount=$ApperrorQuery->get()->count();
        if($request->get('_onlycount')!==null)
            return response()->json(['Data'=>[],'RecordCount'=>$ApperrorsCount], 200);
        $Apperrors=SweetQueryBuilder::setPaginationIfNotNull($ApperrorQuery,$request->get('__startrow'),$request->get('__pagesize'))->get();
        $ApperrorsArray=[];
        for($i=0;$i<count($Apperrors);$i++)
        {
            $ApperrorsArray[$i]=$Apperrors[$i]->toArray();
            $UserField=$Apperrors[$i]->user();
            $ApperrorsArray[$i]['usercontent']=$UserField==null?'':$UserField->name;
        }
        $Apperror = $this->getNormalizedList($ApperrorsArray);
        return response()->json(['Data'=>$Apperror,'RecordCount'=>$ApperrorsCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('appman.apperror.view'))
            //throw new AccessDeniedHttpException();
        $Apperror=appman_apperror::find($id);
        $ApperrorObjectAsArray=$Apperror->toArray();
        $UserObject=$Apperror->user();
        $UserObject=$UserObject==null?'':$UserObject;
        $ApperrorObjectAsArray['userinfo']=$this->getNormalizedItem($UserObject->toArray());
        $Apperror = $this->getNormalizedItem($ApperrorObjectAsArray);
        return response()->json(['Data'=>$Apperror], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('appman.apperror.delete'))
            throw new AccessDeniedHttpException();
        $Apperror = appman_apperror::find($id);
        $Apperror->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}