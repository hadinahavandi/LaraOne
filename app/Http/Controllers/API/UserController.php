<?php

namespace App\Http\Controllers\API;

use App\Classes\OnlinePanelClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
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
        if (Auth::attempt(['email' => request('name'), 'password' => request('password')])) {
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
        $Data['displayname'] = request('name');
        $Data['sessionkey'] = $success['token'];
        $Data['access'] = $user->getAbilities();
        $Data['roles'] = $user->getRoles();

        return response()->json(['success' => $success, 'Data' => $Data,], $this->successStatus);
    }

    public function VerifyAndLogin(Request $request)
    {
        $phone = request('phone');
        $code = request('code');
        $user = User::where('phone', '=', $phone)->first();
        if (empty($user)) {
            return response()->json(['error' => 'User Not Exists'], 404);
        }
        if ($user->code == $code) {
//            $user->code="554897";
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
        $user = User::where('phone', '=', $phone)->first();
        if (empty($user)) {
            $request['email'] = "initial@" . $phone . ".user";
            $request['name'] = $phone;
            $request['password'] = $phone;
            $request['c_password'] = $phone;
            $user = $this->makeUserFromRequest($request);
        }
        $code = mt_rand(10000, 99999);
        $user->code = $code;
        $user->codeexpire_time = time();
        $user->save();
        $opC = new OnlinePanelClient("20002222332458");
        $opC->sendSMS($phone, $code);
        return response()->json(['code' => $code], 201);

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
            'email' => 'required|email',
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