<?php
namespace App\Http\Controllers\contactus\API;
use App\models\contactus\contactus_subject;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SubjectController extends SweetController
{

    public function add(Request $request)
    {
        if(!Bouncer::can('contactus.subject.insert'))
            throw new AccessDeniedHttpException();

        $Name=$request->input('name');
        $Subject = contactus_subject::create(['name'=>$Name,'deletetime'=>-1]);
        return response()->json(['Data'=>$Subject], 201);
    }
    public function update($id,Request $request)
    {
        if(!Bouncer::can('contactus.subject.edit'))
            throw new AccessDeniedHttpException();

        $Name=$request->get('name');
        $Subject = new contactus_subject();
        $Subject = $Subject->find($id);
        $Subject->name=$Name;
        $Subject->save();
        return response()->json(['Data'=>$Subject], 202);
    }
    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('contactus.subject.insert');
        Bouncer::allow('admin')->to('contactus.subject.edit');
        Bouncer::allow('admin')->to('contactus.subject.list');
        Bouncer::allow('admin')->to('contactus.subject.view');
        Bouncer::allow('admin')->to('contactus.subject.delete');

        //if(!Bouncer::can('contactus.subject.list'))
        //throw new AccessDeniedHttpException();
        $SubjectQuery = contactus_subject::where('id','>=','0');
        $SubjectQuery =SweetQueryBuilder::WhereLikeIfNotNull($SubjectQuery,'name',$request->get('name'));
        $Subjects=$SubjectQuery->get();
        $SubjectsArray=[];
        for($i=0;$i<count($Subjects);$i++)
        {
            $SubjectsArray[$i]=$Subjects[$i]->toArray();
        }
        $Subject = $this->getNormalizedList($SubjectsArray);
        return response()->json(['Data'=>$Subject,'RecordCount'=>count($Subject)], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('contactus.subject.view'))
        //throw new AccessDeniedHttpException();
        $Subject = $this->getNormalizedItem(contactus_subject::find($id)->toArray());
        return response()->json(['Data'=>$Subject], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('contactus.subject.delete'))
            throw new AccessDeniedHttpException();
        $Subject = contactus_subject::find($id);
        $Subject->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}