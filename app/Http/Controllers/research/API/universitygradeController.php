<?php
namespace App\Http\Controllers\research\API;
use App\models\research\research_universitygrade;
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
use App\Http\Requests\research\universitygrade\research_universitygradeAddRequest;
use App\Http\Requests\research\universitygrade\research_universitygradeUpdateRequest;
use App\Http\Requests\research\universitygrade\research_universitygradeListRequest;

class UniversitygradeController extends SweetController
{
    private $ModuleName='research';

    public function list(research_universitygradeListRequest $request)
    {
        /*
        Bouncer::allow('admin')->to('research.universitygrade.list');
        Bouncer::allow('admin')->to('research.universitygrade.view');
        */
        $SearchText=$request->get('searchtext');
        $UniversitygradeQuery = research_universitygrade::where('id','>=','0');
        $UniversitygradeQuery =SweetQueryBuilder::WhereLikeIfNotNull($UniversitygradeQuery,'name',$SearchText);
        $UniversitygradeQuery =SweetQueryBuilder::WhereLikeIfNotNull($UniversitygradeQuery,'name',$request->get('name'));
        $UniversitygradeQuery = SweetQueryBuilder::orderByFields($UniversitygradeQuery, $request->getOrderFields());
        $UniversitygradesCount=$UniversitygradeQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$UniversitygradesCount], 200);
        $Universitygrades=SweetQueryBuilder::setPaginationIfNotNull($UniversitygradeQuery,$request->getStartRow(),$request->getPageSize())->get();
        $UniversitygradesArray=[];
        for($i=0;$i<count($Universitygrades);$i++)
        {
            $UniversitygradesArray[$i]=$Universitygrades[$i]->toArray();
        }
        $Universitygrade = $this->getNormalizedList($UniversitygradesArray);
        return response()->json(['Data'=>$Universitygrade,'RecordCount'=>$UniversitygradesCount], 200);
    }
    public function get($id,Request $request)
    {
        $Universitygrade=research_universitygrade::find($id);
        $UniversitygradeObjectAsArray=$Universitygrade->toArray();
        $Universitygrade = $this->getNormalizedItem($UniversitygradeObjectAsArray);
        return response()->json(['Data'=>$Universitygrade], 200);
    }
}