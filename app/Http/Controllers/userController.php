<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\sendOTPMail;
use App\Models\goldUser;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class userController extends Controller
{

    public function signin(Request $request)
    {


        $data = $request->input();

        $user = goldUser::where('email', '=', $data["email"])->first();

        $c = new userController();


        if ($user == null) {

            //add user

            $user = new goldUser;
            $user->email = $data["email"];
            $user->username = null;
            $user->mobile = null;
            $user->token = null;
            $user->otp = null;

            $user->save();
    
        } else {

            //check verify

            //check token 

            //return this user

            /*
            $token = $user->token;
            if ($token == null) {

                //"need to verify email";


                return Response()->json(["message" => "need to verify account"]);
            } else {


                return Response()->json($user);
            }
            return "check verify";*/
        }

        $newUser = new goldUser();
        $newUser->email = $user->email;
        $newUser->username = $user->username;
        $newUser->mobile = $user->mobile;



        //send email

        $c->sendVerificationEmailAPI($user);

        return Response()->json(["data" => ["items" => $newUser], "code" => 200, "status" => "Success"]);
        
        return "signin";
    }

    public function sendVerificationEmailAPI($user)
    {

        $c = new userController();

        $otp = $c->generateNumericOTP(6);

        $user->otp = $otp;


        $data = [

            "otp" => $otp

        ];

        Mail::to("haayyaa11@gmail.com")->send(new sendOTPMail($data));


        $user->save();

        
    }
    
    public function sendVerificationEmail(Request $request)
    {

        $data = $request->input();

        $user = goldUser::where('email', '=', $data["email"])->first();

        $c = new userController();

        $otp = $c->generateNumericOTP(6);

        $user->otp = $otp;


        $data = [

            "otp" => $otp

        ];

        Mail::to("haayyaa11@gmail.com")->send(new sendOTPMail($data));


        $user->save();

        return $user;
    }

    public function verifyAccount(Request $request)
    {

        //dd($request);
        $c = new userController();
        $data = $request->input();
        $user = goldUser::where("email", "=", $data["email"])->first();

        if ($user == null) {

            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }


        $token = $user->token;


        /*
        if ($token != null) {

            return Response()->json(["data" => "this user already verified", "code" => -110, "status" => "Error"]);
        }
*/

        $otp = $data["otp"];

        $userOTP = $user->otp;
        /* very important should to uncomment
        if ($userOTP != $otp) {
            return Response()->json(["data" => "otp not correct", "code" => -120, "status" => "Error"]);
        }
*/


        //generate token 
        $token = $c->generateToken();

        $user->token = $token;
        $user->save();

        return Response()->json(["data" => ["token" => $user->token], "code" => 200, "status" => "Success"]);


        return "verifyAccount";
    }
    public function updateProfile(Request $request)
    {


        $c = new userController();
        $data = $request->input();
        $user = goldUser::where("token", "=", $data["token"])->first();

        if ($user == null) {

            return Response()->json(["data" => "user not found", "code" => -300, "status" => "Error"]);
        }

        $username = $data["username"];
        $mobile = $data["mobile"];


        if ($username == "" || $mobile == "") {

            return Response()->json(["data" => "please enter username and mobile", "code" => -130, "status" => "Error"]);
        }
        $user->username = $username;
        $user->mobile = $mobile;

        $user->save();


        $newUser = new goldUser();
        $newUser->email = $user->email;
        $newUser->username = $user->username;
        $newUser->mobile = $user->mobile;

        return Response()->json(["data" => $newUser, "code" => 200, "status" => "Success"]);
        return "updateProfile";
    }



    //helper functions 

    function generateToken()
    {
        //$number = mt_rand(1000000000, 9999999999); // better than rand()

        $number = Str::random(32);
        $c = new userController();
        // call the same function if the barcode exists already
        if ($c->barcodeNumberExists($number)) {
            return $c->generateToken();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    function barcodeNumberExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return goldUser::where("token", "=", $number)->exists();
    }

    function generateNumericOTP($n)
    {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        // Return result
        return $result;
    }
}
