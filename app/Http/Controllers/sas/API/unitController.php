<?php
namespace App\Http\Controllers\sas\API;
use App\Http\Controllers\sas\Classes\Unit;
use App\models\sas\sas_unit;
use App\Http\Controllers\Controller;
use App\models\sas\sas_unittype;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use App\User;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnitController extends SweetController
{

	public function add(Request $request)
    {
//        if(!Bouncer::can('sas.unit.insert'))
//            throw new AccessDeniedHttpException();
    
		$InputName=$request->input('name');
		$InputLogoigu=$request->file('logoigu');
        if($InputLogoigu!=null){
            $InputLogoigu->move('img/',$InputLogoigu->getClientOriginalName());
            $InputLogoigu='img/'.$InputLogoigu->getClientOriginalName();
        }
        else
        { 
            $InputLogoigu='';
        }
        $InputUnittype=$request->input('unittype');
        $UnitType=sas_unittype::find($InputUnittype);
        if($UnitType==null)
            return ['Data'=>'Error'];
        else
        {
            $InputNeedsadminapproval=$request->input('needsadminapproval');
            $Unit = sas_unit::create(['name'=>$InputName,'logo_igu'=>$InputLogoigu,'is_needsadminapproval'=>$InputNeedsadminapproval,'unittype_fid'=>$InputUnittype,'deletetime'=>-1]);

            $User1=User::create([
                'name' => "کاربر بخش شماره ". $Unit->id,
                'email' =>'user1@unit'.$Unit->id.".c",
                'password' => Hash::make('12345678'),
            ]);
            $User1->assign("type".$InputUnittype."_unituser");
            $Unit->user__user_fid=$User1->id;

            $Admin=User::create([
                'name' => "مدیر بخش شماره ". $Unit->id,
                'email' =>'user2@unit'.$Unit->id.".c",
                'password' => Hash::make('12345678'),
            ]);
            $Admin->assign("type".$InputUnittype."_unitadmin");
            $Unit->admin__user_fid=$Admin->id;

            $Security=User::create([
                'name' => "امنیت بخش شماره ". $Unit->id,
                'email' =>'user3@unit'.$Unit->id.".c",
                'password' => Hash::make('12345678'),
            ]);
            $Security->assign("type".$InputUnittype."_unitsecurity");
            $Unit->security__user_fid=$Security->id;


            $Unit->save();
            return response()->json(['Data'=>$Unit], 201);
        }

	}
    public function update($id,Request $request)
    {
        if(!Bouncer::can('sas.unit.edit'))
            throw new AccessDeniedHttpException();

        $InputName=$request->get('name');
        $InputLogoigu=$request->file('logoigu');
        if($InputLogoigu!=null){
            $InputLogoigu->move('img/',$InputLogoigu->getClientOriginalName());
            $InputLogoigu='img/'.$InputLogoigu->getClientOriginalName();
        }
        else
        {
            $InputLogoigu='';
        }
        $InputUnittype=$request->get('unittype');
        $InputNeedsadminapproval=$request->get('needsadminapproval');
//        $InputUseruser=$request->get('useruser');
//        $InputAdminuser=$request->get('adminuser');
//        $InputSecurityuser=$request->get('securityuser');
        $Unit = new sas_unit();
        $Unit = $Unit->find($id);
        $Unit->name=$InputName;
        if($InputLogoigu!=null)
            $Unit->logo_igu=$InputLogoigu;
        $Unit->unittype_fid=$InputUnittype;
        $Unit->is_needsadminapproval=$InputNeedsadminapproval;
//        $Unit->user__user_fid=$InputUseruser;
//        $Unit->admin__user_fid=$InputAdminuser;
//        $Unit->security__user_fid=$InputSecurityuser;
        $Unit->save();
        return response()->json(['Data'=>$Unit], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('sas.unit.insert');
        Bouncer::allow('admin')->to('sas.unit.edit');
        Bouncer::allow('admin')->to('sas.unit.list');
        Bouncer::allow('admin')->to('sas.unit.view');
        Bouncer::allow('admin')->to('sas.unit.delete');
        //if(!Bouncer::can('sas.unit.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $UnitQuery = sas_unit::where('id','>=','0');
        $UnitQuery = SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery, 'name', $SearchText);
        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'name',$request->get('name'));
        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'unittype_fid',$request->get('unittype'));
        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'is_needsadminapproval',$request->get('needsadminapproval'));
//        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'user__user_fid',$request->get('useruser'));
//        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'admin__user_fid',$request->get('adminuser'));
//        $UnitQuery =SweetQueryBuilder::WhereLikeIfNotNull($UnitQuery,'security__user_fid',$request->get('securityuser'));

        $UnitQuery = SweetQueryBuilder::setPaginationIfNotNull($UnitQuery, $request->get('__startrow'), $request->get('__pagesize'));
        $Units=$UnitQuery->get();
        $UnitsArray=[];
        for($i=0;$i<count($Units);$i++)
        {
            $UnitsArray[$i]=$Units[$i]->toArray();
            $UnittypeField=$Units[$i]->unittype();
            $UnitsArray[$i]['unittypecontent']=$UnittypeField==null?'':$UnittypeField->name;
            $UseruserField=$Units[$i]->useruser();
            $UnitsArray[$i]['userusercontent']=$UseruserField==null?'':$UseruserField->email;
            $AdminuserField=$Units[$i]->adminuser();
            $UnitsArray[$i]['adminusercontent']=$AdminuserField==null?'':$AdminuserField->email;
            $SecurityuserField=$Units[$i]->securityuser();
            $UnitsArray[$i]['securityusercontent']=$SecurityuserField==null?'':$SecurityuserField->email;
        }
        $Unit = $this->getNormalizedList($UnitsArray);
        return response()->json(['Data'=>$Unit,'RecordCount'=>count($Unit)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('sas.unit.view'))
            //throw new AccessDeniedHttpException();
        $Unit = $this->getNormalizedItem(sas_unit::find($id)->toArray());
        return response()->json(['Data'=>$Unit], 200);
    }
    public function getUserUnitInfo(Request $request)
    {
        //if(!Bouncer::can('sas.unit.view'))
        //throw new AccessDeniedHttpException();
        $UserID=Auth::user()->getAuthIdentifier();
        $UnitInfo=Unit::getUserUnitAndType();
        return response()->json(['Data'=>$UnitInfo], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('sas.unit.delete'))
            throw new AccessDeniedHttpException();
        $Unit = sas_unit::find($id);
        $Unit->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}