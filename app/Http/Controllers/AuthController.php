<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller {

    public function register(Request $request) {

        $fields = $request->validate([
            'cpr'       => 'required|string',
            'email'     => 'required|string|unique:users,email',
            'password'  => 'required|string'
        ]);

        //-------------------------------------------------------------
        // Checking The System
        //-------------------------------------------------------------

            // Reading User Input
            $cpr        = $request->cpr;
            $email      = $request->email;
            $password   = bcrypt($request->password);
        
            // First Query
            $result = DB::select('select * from users where cpr = ?', [$cpr]);

            // Person Is Available
            if(sizeof($result) == 1) {

                $result         = json_decode(json_encode($result[0]));
                $email_av       = false;
                $password_av    = false;

                // To Make Sure The Email Exist
                if(!is_null($result->email) || !empty($result->email)) {
                    $email_av = true;
                }

                // To Make Sure The User Have A Password
                if(!is_null($result->password) || $result->password == " ") {
                    $password_av = true;
                }

                // Case 1 : Person Email Exist & Password Exist
                if($email_av == true && $password_av == true) {

                    $message                = new \stdClass();
                    $message->permission    = "rejected";
                    $message->body          = "Case 1 : Email Available, Password Available, Please Contact HR Department for Password Reset";

                    $response = [
                        'user'              => NULL,
                        'token'             => NULL,
                        'message'           => json_encode($message),
                    ];

                    return response($response, 400);

                // Case 2 : Person Email Exist & Password Not Exist
                } else if($email_av == true && $password_av == false) {

                    $message                = new \stdClass();
                    $message->permission    = "accepted";
                    $message->body          = "Case 2 : Email Available, Password Not Available, Updated Your Password";

                    $res2                   = DB::update('update users set password = ? where cpr = ?', [$password, $cpr]);
                    $id                     = $result->id;
                    $user                   = User::find($id);
                    $token                  = $user->createToken('flutterAppToken')->plainTextToken;

                    $response = [
                        'user'              => $user,
                        'token'             => $token,
                        'message'           => json_encode($message),
                    ];

                    return response($response, 201);

                // Case 3 : Person Email Not Exist & Password Not Exist
                } else {

                    $message                = new \stdClass();
                    $message->permission    = "accepted";
                    $message->body          = "Case 3 : Email Not Available, Password Not Available, Updated Your Email & Password";

                    $res2                   = DB::update('update users set email = ?, password = ? where cpr = ?', [$email, $password, $cpr]);
                    $id                     = $result->id;
                    $user                   = User::find($id);
                    $token                  = $user->createToken('flutterAppToken')->plainTextToken;

                    $response = [
                        'user'              => $user,
                        'token'             => $token,
                        'message'           => json_encode($message),
                    ];

                    return response($response, 201);
                    
                }

            } else {

                $message                = new \stdClass();
                $message->permission    = "rejected";
                $message->body          = "Case 4 : There is no user with that CPR";

                $response = [
                    'user'              => NULL,
                    'token'             => NULL,
                    'message'           => $message,
                ];

                return response($response, 400);

            }

        //-------------------------------------------------------------
        // Checking The System
        //-------------------------------------------------------------

    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('flutterAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
        
    }

}

