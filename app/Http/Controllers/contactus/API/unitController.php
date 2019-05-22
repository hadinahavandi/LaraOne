<?php
namespace App\Http\Controllers\contactus\API;
use App\models\contactus\contactus_unit;
use App\Http\Controllers\Controller;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnitController extends SweetController
{

public function add(Request $request)
    {
        if(!Bouncer::can('contactus.unit.insert'))
            throw new AccessDeniedHttpException();
    
$Name=$request->input('name');
$Unit = contactus_unit::create(['name'=>$Name,'deletetime'=>-1]);
return response()->json(['Data'=>$Unit], 201);
}
public function update($id,Request $request)
    {
        if(!Bouncer::can('contactus.unit.edit'))
            throw new AccessDeniedHttpException();
$Name=$request->get('name');
$Unit = new contactus_unit();
$Unit = $Unit->find($id);
$Unit->name=$Name;
$Unit->save();
return response()->json(['Data'=>$Unit], 202);
}
public function list()
{

//    Bouncer::allow('admin')->to('contactus.unit.insert');
//    Bouncer::allow('admin')->to('contactus.unit.edit');
//    Bouncer::allow('admin')->to('contactus.unit.list');
//    Bouncer::allow('admin')->to('contactus.unit.view');
//    Bouncer::allow('admin')->to('contactus.unit.delete');
//                    if(!Bouncer::can('contactus.unit.list'))
//                        throw new AccessDeniedHttpException();
$Unit = $this->getNormalizedList(contactus_unit::all()->toArray());
return response()->json(['Data'=>$Unit,'RecordCount'=>count($Unit)], 200);
}
public function get($id,Request $request)
{
//                    if(!Bouncer::can('contactus.unit.view'))
//                        throw new AccessDeniedHttpException();
$Unit = $this->getNormalizedItem(contactus_unit::find($id)->toArray());
return response()->json(['Data'=>$Unit], 200);
}
public function delete($id,Request $request)
{
                    if(!Bouncer::can('contactus.unit.delete'))
                        throw new AccessDeniedHttpException();
$Unit = contactus_unit::find($id);
$Unit->delete();
return response()->json(['message'=>'deleted','Data'=>[]], 202);
}
}