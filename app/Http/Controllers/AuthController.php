<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller {

    public function register2(Request $request) {

        $cpr        = $request->cpr;
        $email      = $request->email;
        $password   = bcrypt($request->password);
      
        // First Query
        $result = DB::select('select * from users where cpr = ?', [$cpr]);

        // Person Is Available
        if(sizeof($result) == 1) {

            $result = $result[0];

            $email_av       = false;
            $password_av    = false;

            if(!is_null($result->email) || !empty($result->email)) {
                $email_av = true;
            }

            if(!is_null($result->password) || $result->password == " ") {
                $password_av = true;
            }

            // Case 1
            if($email_av == true && $password_av == true) {

                $message                = new \stdClass();
                $message->permission    = "rejected";
                $message->body          = "Case 1 : Email Available, Password Available, Please Contact HR Department for Password Reset";
                return json_encode($message);

            // Case 2
            } else if($email_av == true && $password_av == false) {
                
                $message                = new \stdClass();
                $message->permission    = "accepted";
                $message->body          = "Case 2 : Email Available, Password Not Available";
                $result                 = DB::update('update employees set password = ? where cpr_number = ?', [$password, $cpr]);
                return json_encode($message);

            // Case 3
            } else if($email_av == false && $password_av == true) {

                $message                = new \stdClass();
                $message->permission    = "rejected";
                $message->body          = "Case 3 : Email Not Available, Password Available";
                return json_encode($message);

            // Case 4
            } else {

                $message                = new \stdClass();
                $message->permission    = "accepted";
                $result                 = DB::update('update employees set email = ?, password = ? where cpr_number = ?', [$email, $password, $cpr]);
                $message->body          = "Case 4 : Email Not Available, Password Not Available, Updated Successfully";
                return json_encode($message);

            }
        } else {

            $message                = new \stdClass();
            $message->permission    = "rejected";
            $message->body          = "Sorry Person Doesn't Exist";
            return json_encode($message);
        }
    }

    public function register(Request $request) {

        $fields = $request->validate([
            'cpr'       => 'required|string',
            'email'     => 'required|string|unique:users,email',
            'password'  => 'required|string|confirmed'
        ]);

        //-------------------------------------------------------------
        // Checking The System
        //-------------------------------------------------------------

            $cpr        = $request->cpr;
            $email      = $request->email;
            $password   = bcrypt($request->password);
        
            // First Query
            $result = DB::select('select * from users where cpr = ?', [$cpr]);

            // Person Is Available
            if(sizeof($result) == 1) {

                $result         = $result[0];
                $email_av       = false;
                $password_av    = false;

                if(!is_null($result->email) || !empty($result->email)) {
                    $email_av = true;
                }

                if(!is_null($result->password) || $result->password == " ") {
                    $password_av = true;
                }

                // Case 1
                if($email_av == true && $password_av == true) {
                    // $message                = new \stdClass();
                    // $message->permission    = "rejected";
                    // $message->body          = "Case 1 : Email Available, Password Available, Please Contact HR Department for Password Reset";
                    // return json_encode($message);
                // Case 2
                } else if($email_av == true && $password_av == false) {
                    // $message                = new \stdClass();
                    // $message->permission    = "accepted";
                    // $message->body          = "Case 2 : Email Available, Password Not Available";
                    $result                 = DB::update('update users set email = ?, password = ? where cpr = ?', [$email, $password, $cpr]);
                    $user                   = User::find($result->id);
                    $token                  = $user->createToken('flutterAppToken')->plainTextToken;
                    $response = [
                        'user'      => $user,
                        'token'     => $token
                    ];
                    return response($response, 201);
                    // $result                 = DB::update('update users set password = ? where cpr = ?', [$password, $cpr]);
                    // return json_encode($message);
                // Case 3
                } else if($email_av == false && $password_av == true) {
                    $message                = new \stdClass();
                    $message->permission    = "rejected";
                    // $message->body          = "Case 3 : Email Not Available, Password Available";
                    // return json_encode($message);
                // Case 4
                } else {
                    // $message                = new \stdClass();
                    // $message->permission    = "accepted";
                    $result                 = DB::update('update users set email = ?, password = ? where cpr = ?', [$email, $password, $cpr]);
                    $user                   = User::find($result[0]->id);
                    $token                  = $user->createToken('flutterAppToken')->plainTextToken;
                    $response = [
                        'user'      => $user,
                        'token'     => $token
                    ];
                    return response($response, 201);
                    // $message->body          = "Case 4 : Email Not Available, Password Not Available, Updated Successfully";
                    // return json_encode($message);
                }

            } else {
                $message                = new \stdClass();
                $message->permission    = "rejected";
                $message->body          = "Sorry Person Doesn't Exist";
                return json_encode($message);
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

