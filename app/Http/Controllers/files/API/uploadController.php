<?php
namespace App\Http\Controllers\files\API;
use App\models\pages\pages_page;
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
use App\Http\Requests\pages\page\pages_pageAddRequest;
use App\Http\Requests\pages\page\pages_pageUpdateRequest;
use App\Http\Requests\pages\page\pages_pageListRequest;

class UploadController extends SweetController
{
    private $ModuleName='files';

	public function uploadImage(Request $request)
    {
        Bouncer::allow('admin')->to('files.upload');
        if(!Bouncer::can('files.upload'))
            throw new AccessDeniedHttpException();
        $location='';
        if($request->file('file')!=null)
            $location=$this->uploadFromRequest($request->file('file'),'files/img','uploadedimage','.png');

        return response()->json(['Data'=>['location'=>$location]], 201);
	}
    private function uploadFromRequest($InputFile,$Location,$NamePrefix,$NamePostFix)
    {
        $Path = "";
        if ($InputFile != null) {
            $Name=0;
            $NameFound=false;
            while (!$NameFound){
                if(!file_exists($Location.'/'.$this->getName($NamePrefix,$Name,$NamePostFix))){
                    $NameFound=true;
                }
                else{
                    $Name++;
                }
            }
            $InputFile->move($Location, $this->getName($NamePrefix,$Name,$NamePostFix));
            $Path = $Location.'/'.$this->getName($NamePrefix,$Name,$NamePostFix);
        }
        return $Path;
    }
    public function getName($NamePrefix,$Name,$NamePostFix)
    {
        return  $NamePrefix.'-'.$Name.'-'.$NamePostFix;
    }
}