<?php
namespace App\Http\Controllers\pages\API;
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

class PageController extends SweetController
{
    private $ModuleName='pages';

	public function add(pages_pageAddRequest $request)
    {
        //if(!Bouncer::can('pages.page.insert'))
            //throw new AccessDeniedHttpException();
        $request->validated();
    
		$Page = new pages_page();
        $Page->name=$request->getName();
        $Page->title=$request->getTitle();
        $Page->content_te=$request->getContentte();
        $Page->is_published=$request->getPublished();
        $Page->keywords=$request->getKeywords();
		$Page->save();
		return response()->json(['Data'=>$Page], 201);
	}
	public function update($id,pages_pageUpdateRequest $request)
    {
        if(!Bouncer::can('pages.page.edit'))
            throw new AccessDeniedHttpException();
        $request->setIsUpdate(true);
        $request->validated();
            
    
//        $Page = new pages_page();
        $Page = pages_page::find($id);
        $Page->name=$request->getName();
        $Page->title=$request->getTitle();
        $Page->content_te=$request->getContentte();
        $Page->is_published=$request->getPublished();
        $Page->keywords=$request->getKeywords();
        $Page->save();
        return response()->json(['Data'=>$Page], 202);
    }
    public function list(pages_pageListRequest $request)
    {

        Bouncer::allow('admin')->to('pages.page.insert');
        Bouncer::allow('admin')->to('pages.page.edit');
        Bouncer::allow('admin')->to('pages.page.list');
        Bouncer::allow('admin')->to('pages.page.view');
        Bouncer::allow('admin')->to('pages.page.delete');

        //if(!Bouncer::can('pages.page.list'))
            //throw new AccessDeniedHttpException();
        $SearchText=$request->get('searchtext');
        $PageQuery = pages_page::where('id','>=','0');
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'title',$SearchText);
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'name',$request->get('name'));
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'title',$request->get('title'));
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'content_te',$request->get('contentte'));
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'is_published',$request->get('published'));
        $PageQuery =SweetQueryBuilder::WhereLikeIfNotNull($PageQuery,'keywords',$request->get('keywords'));
        $PageQuery = SweetQueryBuilder::orderByFields($PageQuery, $request->getOrderFields());
        $PagesCount=$PageQuery->get()->count();
        if($request->isOnlyCount())
            return response()->json(['Data'=>[],'RecordCount'=>$PagesCount], 200);
        $Pages=SweetQueryBuilder::setPaginationIfNotNull($PageQuery,$request->getStartRow(),$request->getPageSize())->get();
        $PagesArray=[];
        for($i=0;$i<count($Pages);$i++)
        {
            $PagesArray[$i]=$Pages[$i]->toArray();
        }
        $Page = $this->getNormalizedList($PagesArray);
        return response()->json(['Data'=>$Page,'RecordCount'=>$PagesCount], 200);
    }
    public function get($id,Request $request)
    {
        //if(!Bouncer::can('pages.page.view'))
            //throw new AccessDeniedHttpException();
        $Page=pages_page::find($id);
        $PageObjectAsArray=$Page->toArray();
        $Page = $this->getNormalizedItem($PageObjectAsArray);
        return response()->json(['Data'=>$Page], 200);
    }
    public function getByName($name,Request $request)
    {
        //if(!Bouncer::can('pages.page.view'))
        //throw new AccessDeniedHttpException();
        $name=trim($name);
        $Page=pages_page::where('name','=',$name)->get();
        if($Page==null || count($Page)==0)
            return response()->json(['error'=>'صفحه مورد نظر پیدا نشد.'], 404);
        $Page=$Page[0];
        $PageObjectAsArray=$Page->toArray();
        $Page = $this->getNormalizedItem($PageObjectAsArray);
        return response()->json(['Data'=>$Page], 200);
    }
    public function delete($id,Request $request)
    {
        if(!Bouncer::can('pages.page.delete'))
            throw new AccessDeniedHttpException();
        $Page = pages_page::find($id);
        $Page->delete();
        return response()->json(['message'=>'deleted','Data'=>[]], 202);
    }
}