<?php

namespace App\Http\Controllers\placeman\API;

use App\models\placeman\placeman_area;
use App\models\Branch;
use App\models\Branchadmin;
use App\models\placeman\placeman_city;
use App\models\Company;
use App\models\Place;
use App\models\placeman\placeman_province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class PlacemanController extends Controller
{
    private $SERVERPATH = "/home/sweetsof/public_html/babimeh/placeman";

    public function listPlaces()
    {
        $Places = Branch::getBranchPlaces(700, 1, Branch::$ALL);
        return response()->json($Places, 200);
    }

    public function listInactivePlaces()
    {
        return response()->json(Branch::getBranchPlaces(700, 0, Branch::$ALL), 200);
    }

    public function listAllPlaces()
    {
        $Places = Branch::getBranchPlaces(1500, -1, Branch::$ALL);
        return response()->json($Places, 200);
    }

    public function changePlaceActivation($branch_id, $isActive)
    {
        $Branch = new Branch();
        $Branch = $Branch->find($branch_id);
        if ($isActive == 1) {
            $Branch->isactive = true;
            $Branch->save();
            return response()->json(['message' => 'فعال سازی با موفقیت انجام شد.'], 200);
        } elseif ($isActive == 0) {

            $Branch->isactive = false;
            $Branch->save();
            return response()->json(['message' => 'غیر فعال سازی با موفقیت انجام شد.'], 200);
        } elseif ($isActive == 2) {
            $Place = new Place();
            $Place = $Place->find($Branch->place_id);
            $BranchAdmin = new Branchadmin();
            $BranchAdmin = $BranchAdmin->find($Branch->branchadmin_id);
            $User = new User();
            $User = $User->find($BranchAdmin->user_id);
            $Branch->delete();
            $Place->delete();
            $BranchAdmin->delete();
            $User->delete();
            return response()->json(['message' => 'حذف با موفقیت انجام شد.'], 200);
        }
    }

    public function getBranch($branch_id)
    {
        $Branch = new Branch();
        $Branch = $Branch->find($branch_id);
        $Company = new Company();
        $Company = $Company->find($Branch->company_id);
        $Place = new Place();
        $Place = $Place->find($Branch->place_id);

        if ($Branch != null)
            return response()->json(["branch" => $Branch, "company" => $Company, "place" => $Place], 200);
        return response()->json([], 200);
    }

    public function getBranchFullInfo($branch_id)
    {
        $Branch = new Branch();
        $Branch = $Branch->find($branch_id);
        $BranchAdmin = new Branchadmin();
        $BranchAdmin = $BranchAdmin->find($Branch->branchadmin_id);
        $Company = new Company();
        $Company = $Company->find($Branch->company_id);
        $Place = new Place();
        $Place = $Place->find($Branch->place_id);
        if ($Branch != null)
            return response()->json(["branch" => $Branch, "company" => $Company, "place" => $Place, "branchadmin" => $BranchAdmin], 200);
        return response()->json([], 200);
    }

    public function getUserBranch()
    {
        $ID = Auth::user()->getAuthIdentifier();
        $Branchadmin = Branchadmin::where('user_id', $ID)->first();
        $Branch = Branch::where('branchadmin_id', $Branchadmin->id)->first();
//        $Branch=new Branch();
//        $Branch=$Branch->find($branch_id);
        $Company = new Company();
        $Company = $Company->find($Branch->company_id);
        $Place = new Place();
        $Place = $Place->find($Branch->place_id);
        $Area = new placeman_area();
        $Area = $Area->find($Branch->area_id);
        $City = new placeman_city();
        $City = $City->find($Area->city_id);
        $Province = new placeman_province();
        $Province = $Province->find($City->province_id);
        if ($Branch != null)
            return response()->json(["branch" => $Branch, "company" => $Company, "place" => $Place, 'branchadmin' => $Branchadmin, 'area' => $Area, 'city' => $City, 'province' => $Province], 200);
        return response()->json([], 200);
    }

    public function listProvinces()
    {
        $provinces = placeman_province::all(['*']);
        return response()->json(['Data' => $provinces, 'RecordCount' => count($provinces)], 200);

    }

    public function listCities($Province_id)
    {
        $cities = placeman_city::where('province_id', $Province_id)
            ->orderBy('title', 'asc')
            ->take(100)
            ->get();

        return response()->json(['Data' => $cities, 'RecordCount' => count($cities)], 200);
//        return response()->json([['title'=>'iran'],['title'=>$ID."I"]], 200);
    }

    public function listAreas($Province_id, $CityID)
    {
        $Areas = placeman_area::where('city_id', $CityID)
            ->orderBy('title', 'asc')
            ->take(100)
            ->get();
        return response()->json(['Data' => $Areas, 'RecordCount' => count($Areas)], 200);

    }

    public function listCompanies()
    {
//        $ID=Auth::user()->getAuthIdentifier();
        return response()->json(Company::all(["*"]), 200);
//        return response()->json([['title'=>'iran'],['title'=>$ID]], 200);
    }

    private function validateFields(Request $request, $IsAdd)
    {
        $Fileds = [
            'latitude' => 'required',
            'longitude' => 'required',
            'title' => 'required|min:2',
            'tel' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'address' => 'required|min:8',
            'fundationyear' => 'required|numeric|min:2',
            'code' => 'required|numeric|min:1',
            'area_id' => 'required|numeric',
            'name' => 'required|min:2',
            'family' => 'required|min:2',
            'mellicode' => 'required|numeric|min:10',
            'mobile' => 'required|numeric|min:11',
        ];
        if (!$IsAdd) {
            $Fileds = [
                'latitude' => 'required',
                'longitude' => 'required',
                'title' => 'required|min:2',
                'tel' => 'required|numeric',
                'email' => 'required|email',
                'address' => 'required|min:8',
                'fundationyear' => 'required|numeric|min:2',
                'code' => 'required|numeric|min:1',
                'area_id' => 'required|numeric',
                'name' => 'required|min:2',
                'family' => 'required|min:2',
                'mellicode' => 'required|numeric|min:10',
                'mobile' => 'required|numeric|min:11',
            ];
        }
        $this->validate($request, $Fileds, [
            'title.required' => 'وارد کردن عنوان اجباری است',
            'tel.required' => 'وارد کردن تلفن اجباری است',
            'email.required' => 'وارد کردن ایمیل اجباری است',
            'email.unique' => 'کاربری با این آدرس ایمیل موجود است.',
            'address.required' => 'وارد کردن آدرس اجباری است',
            'fundationyear.required' => 'وارد کردن سال تاسیس اجباری است',
            'code.required' => 'وارد کردن کد اجباری است',
            'area_id.required' => 'وارد کردن منطقه اجباری است',
            'name.required' => 'وارد کردن نام اجباری است',
            'family.required' => 'وارد کردن نام خانوادگی اجباری است',
            'mellicode.required' => 'وارد کردن کد ملی اجباری است',
            'mobile.required' => 'وارد کردن موبایل اجباری است',
            'title.min' => ' عنوان خیلی کوتاه است',
            'code.min' => ' کد خیلی کوتاه است',
            'address.min' => ' آدرس خیلی کوتاه است',
            'password.min' => ' کلمه عبور خیلی کوتاه است',
            'name.min' => ' نام خیلی کوتاه است',
            'family.min' => ' نام خانوادگی خیلی کوتاه است',
            'mellicode.min' => 'کد ملی باید 10 رقمی باشد، در صورت وجود صفر در ابتدای کد ملی می بایست آن را نیز وارد کنید',
            'mobile.min' => ' شماره موبایل صحیح نیست، شماره موبایل باید با 09 شروع شود',
        ]);
    }

    public function add(Request $request)
    {

        $this->validateFields($request, true);

        DB::beginTransaction();
        $latitude = $request->input('latitude') + 0;
        $longitude = $request->input('longitude') + 0;
        $title = $request->input('title');
        $description = $request->input('description');
        $logo = $request->input('logo');
        $tel = $request->input('tel');
        $email = $request->input('email');
        $password = $request->input('password');
        $address = $request->input('address');
        $fundationyear = $request->input('fundationyear');
        $code = $request->input('code');
        $company_id = $request->input('company_id');
        $area_id = $request->input('area_id');
        $name = $request->input('name');
        $family = $request->input('family');
        $melliCode = $request->input('mellicode');
        $mobile = $request->input('mobile');
        $email = strtolower($email);

        $Place = Place::create(['title' => $title, 'description' => $address, 'logo' => $logo, 'latitude' => $latitude, 'longitude' => $longitude]);

        $User = User::where('email', $email);
        if ($User != null && key_exists('id', $User)) {
            $success['token'] = "-1";
            $success['message'] = "کاربری با این ایمیل موجود است.";
            return response()->json($success, 201);
        }

        $licencePath = $this->SERVERPATH . '/public/licences';
        $licenceFile = $request->file('licence');
        $licenceFileURL = "";
        if ($licenceFile != null) {

            $licenceFile->move($licencePath, $Place->id . ".jpg");
            $licenceFileURL = "licences\\" . $Place->id . ".jpg";
        }

        $destinationPath = $this->SERVERPATH . '/public/profilepictures';
        $file = $request->file('photo');
        $photourl = "";
        if ($file != null) {

            $file->move($destinationPath, $Place->id . ".jpg");
            $photourl = "profilepictures\\" . $Place->id . ".jpg";
        }

        $place_id = $Place->id;

        $user = User::create(['name' => $name . " " . $family, 'email' => $email, 'password' => bcrypt($password)]);
        $branchadmin = Branchadmin::create(['name' => $name, 'family' => $family, 'mob' => $mobile, 'user_id' => $user->id, 'mellicode' => $melliCode, 'email' => $email, 'licenceurl' => $licenceFileURL]);
        $branchadmin_id = $branchadmin->id;
        Branch::create(['title' => $title, 'tel' => $tel, 'email' => $email, 'address' => $address, 'isactive' => false, 'fundationyear' => $fundationyear
            , 'code' => $code, 'photourl' => $photourl, 'expire_at' => Carbon::now(), 'company_id' => $company_id, 'area_id' => $area_id, 'place_id' => $place_id, 'branchadmin_id' => $branchadmin_id]);

        $success['token'] = $user->createToken('BaBimeh')->accessToken;
        $success['message'] = "اطلاعات با موفقیت ثبت شد";

        DB::commit();
        return response()->json($success, 201);

    }

    public function edit(Request $request)
    {
        DB::beginTransaction();
        $ID = Auth::user()->getAuthIdentifier();

        $this->validateFields($request, false);
        $Branchadmin = Branchadmin::where('user_id', $ID)->first();
        $Branch = Branch::where('branchadmin_id', $Branchadmin->id)->first();

        $latitude = $request->input('latitude') + 0;
        $longitude = $request->input('longitude') + 0;
        $title = $request->input('title');
        $description = $request->input('description');
        $logo = $request->input('logo');
        $Place = new Place();
        $Place = $Place->find($Branch->place_id);
        $tel = $request->input('tel');
        $email = $request->input('email');
        $email = strtolower($email);

        $address = $request->input('address');
        $fundationyear = $request->input('fundationyear');
        $code = $request->input('code');
        $company_id = $request->input('company_id');
        $area_id = $request->input('area_id');
        $name = $request->input('name');
        $family = $request->input('family');
        $melliCode = $request->input('mellicode');
        $mobile = $request->input('mobile');

        $licencePath = $this->SERVERPATH . '/public/licences';
        $licenceFile = $request->file('licence');
        $licenceFileURL = "";
        if ($licenceFile != null) {

            $licenceFile->move($licencePath, $Place->id . ".jpg");
            $licenceFileURL = "licences\\" . $Place->id . ".jpg";
        }

        $destinationPath = $this->SERVERPATH . '/public/profilepictures';
        $file = $request->file('photo');
        $photourl = "";
        if ($file != null) {
            $file->move($destinationPath, $Place->id . ".jpg");
            $photourl = "profilepictures\\" . $Place->id . ".jpg";
        }
        $Branchadmin->mellicode = $melliCode;
        $Branchadmin->name = $name;
        $Branchadmin->family = $family;
        $Branchadmin->mob = $mobile;
        if ($licenceFileURL != "")
            $Branchadmin->licenceurl = $licenceFileURL;
        $Branchadmin->save();

        $Place->latitude = $latitude;
        $Place->longitude = $longitude;
        $Place->title = $title;
        $Place->description = $address;
        $Place->save();

        $Branch->title = $title;
        $Branch->tel = $tel;
        $Branch->email = $email;
        $Branch->address = $address;
        $Branch->fundationyear = $fundationyear;
        $Branch->code = $code;
        if ($photourl != "")
            $Branch->photourl = $photourl;
        $Branch->company_id = $company_id;
        $Branch->area_id = $area_id;
        $Branch->save();
        DB::commit();
        $success['message'] = "اطلاعات با موفقیت ذخیره شد";
        return response()->json($success, 201);
    }


}
