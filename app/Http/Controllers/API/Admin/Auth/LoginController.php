<?php

namespace App\Http\Controllers\API\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * Handle a Login request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $error["message"] = "Invalid or missing input fields";
            $validation_messages = "";
            foreach ($validator->errors()->toArray() as $name => $value) {
                $validation_messages .= $value[0] . " ";
            }
            $error["validation_messages"] = $validation_messages;
            $error["status"] = "error";
            return response()->json($error, 401);
        }

        if (!$this->guard()->attempt($request->only(['email', 'password']))) {
            //if user authentication fails
            $error["message"] = "Invalid credentials";
            $error["status"] = "error";
            return response()->json($error, 401);
        }

        $user = Admin::where('email', '=', $request->email)->first();
        $APItokenDetails = $user->createToken('shecluded');//this decouplin is done incase other details are needed to be retrieved later
        $APItoken = $APItokenDetails->accessToken;
        //response
        $response = [
            "message" => "Login Successful!",
            "user" => $user,
            "status" => "success",
            "token" => $APItoken
        ];

        return response()->json($response, 200);
    }
}
