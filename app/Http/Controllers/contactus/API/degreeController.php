<?php
namespace App\Http\Controllers\contactus\API;
use App\models\contactus\contactus_degree;
use App\Http\Controllers\Controller;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DegreeController extends SweetController
{

public function add(Request $request)
    {
        if(!Bouncer::can('contactus.degree.insert'))
            throw new AccessDeniedHttpException();
    
$Name=$request->input('name');
$Degree = contactus_degree::create(['name'=>$Name,'deletetime'=>-1]);
return response()->json(['Data'=>$Degree], 201);
}
public function update($id,Request $request)
    {
        if(!Bouncer::can('contactus.degree.edit'))
            throw new AccessDeniedHttpException();
    
$Name=$request->get('name');
$Degree = new contactus_degree();
$Degree = $Degree->find($id);
$Degree->name=$Name;
$Degree->save();
return response()->json(['Data'=>$Degree], 202);
}
public function list()
{
                    //Bouncer::allow('admin')->to('contactus.degree.insert');
                    //Bouncer::allow('admin')->to('contactus.degree.edit');
                    //Bouncer::allow('admin')->to('contactus.degree.list');
                    //Bouncer::allow('admin')->to('contactus.degree.view');
                    //Bouncer::allow('admin')->to('contactus.degree.delete');
//                    if(!Bouncer::can('contactus.degree.list'))
//                        throw new AccessDeniedHttpException();
$Degree = $this->getNormalizedList(contactus_degree::all()->toArray());
return response()->json(['Data'=>$Degree,'RecordCount'=>count($Degree)], 200);
}
public function get($id,Request $request)
{
//                    if(!Bouncer::can('contactus.degree.view'))
//                        throw new AccessDeniedHttpException();
$Degree = $this->getNormalizedItem(contactus_degree::find($id)->toArray());
return response()->json(['Data'=>$Degree], 200);
}
public function delete($id,Request $request)
{
                    if(!Bouncer::can('contactus.degree.delete'))
                        throw new AccessDeniedHttpException();
$Degree = contactus_degree::find($id);
$Degree->delete();
return response()->json(['message'=>'deleted','Data'=>[]], 202);
}
}