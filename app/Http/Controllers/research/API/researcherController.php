<?php
namespace App\Http\Controllers\research\API;
use App\Http\Controllers\mail\classes\mailList;
use App\models\research\research_researcher;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\common\classes\SweetDateManager;
use App\Classes\Sweet\SweetDBFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;
use Bouncer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\research\researcher\research_researcherAddRequest;
use App\Http\Requests\research\researcher\research_researcherUpdateRequest;
use App\Http\Requests\research\researcher\research_researcherListRequest;

class ResearcherController extends SweetController
{
    private $ModuleName='research';

	public function add(research_researcherAddRequest $request)
    {
        //if(!Bouncer::can('research.researcher.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
        $User1=User::create([
            'name' => $request->getName(),
            'email' =>$request->getEmail(),
            'password' => Hash::make($request->getPassword()),
        ]);
        $User1->assign("researcher");
		$Researcher = new research_researcher();
        $Researcher->user_fid=$User1->id;
        $Researcher->name=$request->getName();
        $Researcher->family=$request->getFamily();
        $Researcher->university=$request->getUniversity();
        $Researcher->studyfield=$request->getStudyfield();
        $Researcher->interestarea=$request->getInterestarea();
        $Researcher->tel_num=$request->getTelnum();
        $Researcher->mob_num=$request->getMobnum();
        $Researcher->email=$request->getEmail();
        $Researcher->workstatus_fid=$request->getWorkstatus();
        $Researcher->universitygrade_fid=$request->getUniversityGrade();
        $Researcher->jobfield=$request->getJobfield();
        $Researcher->role=$request->getRole();
        $Researcher->bankcard_bnum=$request->getBankcardbnum();
        $Researcher->city=$request->getCity();
        $Researcher->area=$request->getArea();
        $Researcher->birthyear_num=$request->getBirthyearnum();
        $Researcher->ismale=$request->getMale();
		$Researcher->save();
		$LicenceiguPathDBFile=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'researcher','licenceigu',$Researcher->id,'jpg');
        if($request->getLicenceiguPath()!=null)
            $Researcher->licence_igu=$LicenceiguPathDBFile->uploadFromRequest($request->getLicenceiguPath());
		$Researcher->save();
		return response()->json(['Data'=>$Researcher], 201);
	}
	public function update($id,research_researcherUpdateRequest $request)
    {
        if(!Bouncer::can('research.researcher.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Researcher = new research_researcher();
        $Researcher = research_researcher::find($id);
        $Researcher->user_fid=$request->getUser();
        $Researcher->name=$request->getName();
        $Researcher->family=$request->getFamily();
        $Researcher->university=$request->getUniversity();
        $Researcher->studyfield=$request->getStudyfield();
        $Researcher->interestarea=$request->getInterestarea();
        $Researcher->tel_num=$request->getTelnum();
        $Researcher->mob_num=$request->getMobnum();
        $Researcher->email=$request->getEmail();
        $Researcher->workstatus_fid=$request->getWorkstatus();
        $Researcher->jobfield=$request->getJobfield();
        $Researcher->role=$request->getRole();
        $Researcher->bankcard_bnum=$request->getBankcardbnum();
        $Researcher->city=$request->getCity();
        $Researcher->area=$request->getArea();
        $Researcher->birthyear_num=$request->getBirthyearnum();
        $Researcher->ismale=$request->getMale();
		$LicenceiguPathDBFile=new SweetDBFile(SweetDBFile::$GENERAL_DATA_TYPE_IMAGE,$this->ModuleName,'researcher','licenceigu',$Researcher->id,'jpg');
        if($request->getLicenceiguPath()!=null)
            $Researcher->licence_igu=$LicenceiguPathDBFile->uploadFromRequest($request->getLicenceiguPath());
        $Researcher->save();
        return response()->json(['Data'=>$Researcher], 202);
    }
    public function getQuery(research_researcherListRequest $request)
    {
        $ResearcherQuery = research_researcher::where('id','>=','0');
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'name',$request->get('name'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'family',$request->get('family'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'university',$request->get('university'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'studyfield',$request->get('studyfield'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'interestarea',$request->get('interestarea'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'tel_num',$request->get('telnum'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'mob_num',$request->get('mobnum'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'email',$request->get('email'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'workstatus_fid',$request->get('workstatus'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'jobfield',$request->get('jobfield'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'role',$request->get('role'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'bankcard_bnum',$request->get('bankcardbnum'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'city',$request->get('city'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'area',$request->get('area'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'birthyear_num',$request->get('birthyearnum'));
        $ResearcherQuery =SweetQueryBuilder::WhereLikeIfNotNull($ResearcherQuery,'ismale',$request->get('male'));
        $ResearcherQuery = SweetQueryBuilder::orderByFields($ResearcherQuery, $request->getOrderFields());
        return $ResearcherQuery;
    }
    public function makeMailList(research_researcherListRequest $request)
    {
        $ResearcherQuery = $this->getQuery($request);
        $ResearcherEmails=$ResearcherQuery->get(['email']);
        if($ResearcherEmails==null)
            return response()->json(['Data'=>['mailpostid'=>-1],'RecordCount'=>0], 200);
        $emails=$ResearcherEmails->toArray();
        for($i=0;$i<count($emails);$i++){
            $emails[$i]=$emails[$i]['email'];
        }
        $mailPostID=mailList::makeMailList($emails);
        return response()->json(['Data'=>['mailpostid'=>$mailPostID],'RecordCount'=>0], 200);
    }
    public function list(research_researcherListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('research.researcher.insert');
        Bouncer::allow('admin')->to('research.researcher.edit');
        Bouncer::allow('admin')->to('research.researcher.list');
        Bouncer::allow('admin')->to('research.researcher.view');
        Bouncer::allow('admin')->to('research.researcher.delete');
        */
        //if(!Bouncer::can('research.researcher.list'))
            //throw new AccessDeniedHttpException();
        $ResearcherQuery = $this->getQuery($request);
        $ResearchersCount=$ResearcherQuery->get()->count();
        $ResearcherEmails=$ResearcherQuery->get(['email']);
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$ResearchersCount], 200);
        $Researchers=SweetQueryBuilder::setPaginationIfNotNull($ResearcherQuery,$request->getStartRow(),$request->getPageSize())->get();
        $ResearchersArray=[];
        for($i=0;$i<count($Researchers);$i++)
        {
            $ResearchersArray[$i]=$Researchers[$i]->toArray();
            $UserField=$Researchers[$i]->user();
            $ResearchersArray[$i]['usercontent']=$UserField==null?'':$UserField->name;
            $WorkstatusField=$Researchers[$i]->workstatus();
            $ResearchersArray[$i]['workstatuscontent']=$WorkstatusField==null?'':$WorkstatusField->name;
        }
        $Researcher = $this->getNormalizedList($ResearchersArray);
        $emails=$ResearcherEmails->toArray();
        for($i=0;$i<count($emails);$i++){
            $emails[$i]=$emails[$i]['email'];
        }
        return response()->json(['Data'=>$Researcher,'emails'=>$emails,'RecordCount'=>$ResearchersCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('research.researcher.view'))
            //throw new AccessDeniedHttpException();
        $Researcher=research_researcher::find($id);
        $ResearcherObjectAsArray=$Researcher->toArray();
        $UserObject=$Researcher->user();
        $UserObject=$UserObject==null?'':$UserObject;
        $ResearcherObjectAsArray['userinfo']=$this->getNormalizedItem($UserObject->toArray());
        $WorkstatusObject=$Researcher->workstatus();
        $WorkstatusObject=$WorkstatusObject==null?'':$WorkstatusObject;
        $ResearcherObjectAsArray['workstatusinfo']=$this->getNormalizedItem($WorkstatusObject->toArray());
        $Researcher = $this->getNormalizedItem($ResearcherObjectAsArray);
        return response()->json(['Data'=>$Researcher], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('research.researcher.delete'))
            throw new AccessDeniedHttpException();
        $Researcher = research_researcher::find($id);
        $Researcher->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}