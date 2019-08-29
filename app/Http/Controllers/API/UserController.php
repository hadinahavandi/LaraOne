<?php

namespace App\Http\Controllers\API;

use App\Classes\KavehNegarClient;
use App\Classes\OnlinePanelClient;
use App\models\common\common_app;
use App\models\users\users_appregisterableroles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
use Bouncer;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
//        return response()->json(['Data' => 'ok'], 200);
        if (Auth::attempt(['email' => request('name'), 'password' => request('password')])) {
//            Bouncer::assign('admin')->to(Auth::user());
            return $this->createTokenAndGetUserInfo();
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    private function createTokenAndGetUserInfo()
    {
        $user = Auth::user();
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $Data['sessionkey'] = $success['token'];
        $Data['displayname'] = $user->name;
        $Data['sessionkey'] = $success['token'];
        $Data['access'] = $user->getAbilities();
        $Data['roles'] = $user->getRoles();

        return response()->json(['success' => $success, 'Data' => $Data,], $this->successStatus);
    }

    public function VerifyAndLogin(Request $request)
    {
        $phone = request('phone');
        $code = request('code');
        $appName = request('appName');
        $role = request('role');
        $Identifier = "$phone@$appName.$role";
        $user = User::where('appuseridentifier', '=', $Identifier)->first();
        if (empty($user)) {
            return response()->json(['error' => 'User Not Exists'], 404);
        }
        if ($user->code == $code) {
            $user->code = "95844";
            $user->codeexpire_time = "-1";
            $user->save();
            Auth::login($user);
            return $this->createTokenAndGetUserInfo();

        } else
            return response()->json(['error' => 'Unauthorised'], 401);

    }

    public function SendVerificationCode(Request $request)
    {
        $phone = request('phone');
        $appName = trim(request('appName'));
        $logintype = request('logintype');
        $app = common_app::where('name', '=', $appName)->first();
        if (empty($app))
            return response()->json(['error' => 'App Name Is Invalid'], 404);
        $role = request('role');
        $Identifier = "$phone@$appName.$role";
        $user = User::where('appuseridentifier', '=', $Identifier)->first();
        if (empty($user)) {
            if ($logintype === 'login')
                return response()->json(['message' => 'کاربری با این اطلاعات پیدا نشد.'], 422);
            $ValidRoles = users_appregisterableroles::where('common_app_fid', '=', $app->id)->where('rolename', '=', $role)->first();
            if (empty($ValidRoles))
                return response()->json(['error' => 'Registration Of This Role Is Invalid at This App'], 403);
            $request['email'] = "$appName@" . $phone . "$role.init";
            $request['appuseridentifier'] = $Identifier;
//            $request['name'] = $phone;
            $request['common_app_fid'] = $app->id;
            $request['password'] = $phone;
            $request['c_password'] = $phone;
            $user = $this->makeUserFromRequest($request);
            Bouncer::assign($role)->to($user);
        }
        $code = mt_rand(10000, 99999);
//        $code=12345;
        $user->code = $code;
        $user->codeexpire_time = time();
        $user->save();
//        $opC = new OnlinePanelClient("50002333333321");
        $opC = new KavehNegarClient("1000800808");
        $opC->sendTokenMessage($phone, $code, '', '', 'verify');
        return response()->json(['phone' => $phone], 201);

    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $user = $this->makeUserFromRequest($request);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;
            return response()->json(['success' => $success], $this->successStatus);
        } catch (ValidationException $ex) {
            return response()->json(['error' => $ex], 401);
        }

    }

    private function makeUserFromRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
//            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required|min:11|numeric'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return $user;
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
?>