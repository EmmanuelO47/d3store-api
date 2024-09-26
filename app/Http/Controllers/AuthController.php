<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\InfobipApp;
use App\Models\Token;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Rules\MaxStrings;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Mail;
use Log;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
       // $this->middleware('auth:api', ['except' => ['login', 'register','forgotPassword', 'resetPassword']]);
    }



    public function verify(Request $request)
    {
        $user = User::where(['id'=>$request->user_id]);
        $token = Token::where(['user_id'=>$request->user_id, 'token'=>$request->code]);
        if (!$token){
            return response()->json(["error" => "true", "message"=> "Code is invalid"], 401);
        }else{
            if($token->verified==1){
                return response()->json(["error" => "true", "message"=> "User is already verified, please login"], 401);
            }
            $user->validated = 1;
            $user->email_verified_at = now();
            $user->save();
            $token->verified = 1;
            $token->save();
            return response()->json(["success" => "true", "message"=> "email verified successfully!"], 200);
        }

        // return redirect()->route('login')->with('verified', true);
    }



    public function resetPassword(Request $request)
    {   try {

            $id = ($request->route('id')?$request->route('id'):$request->id);
            $hash = ($request->route('hash')?$request->route('hash'):$request->hash);
            $user = User::find($id);

             if (empty($user)) {
                return response()->json(['error' => "User not exist."], 401);
                // throw new AuthorizationException;
            }
            if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
                return response()->json(['error' => "This Action is Unauthorized."],401);
                // throw new AuthorizationException;
            }
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|confirmed|min:6',
            ], [
                'password.required' => 'Text field cannot be empty, enter your password',
                'password.confirmed' => 'The passwords do not match',
                'password.min' => 'Password must contain six or more characters',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            $user->password = bcrypt($request->password);
            if($user->save()) {
                if($user->enable_app_notification) {
                    createNotification($user->id, 'Your have successfully changed your password. Go to Password Settings to further strenghten your account security.');
                }

                return response()->json(['message' => 'Password changed successfully' ], 201);
            } else {

                return response()->json(['error' => 'Executing request.'], 400);
            }
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
        // $this->redirectPath()
        // return redirect()->route('login')->with('verified', true);
    }



    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if(!User::where(['email'=>$request->email, 'validated'=>1])->exists()) {
            return response()->json(['errors' =>  [ 'email' => 'Invalid username, please check that your account is verified']], 422);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['errors' =>  [ 'password' => 'Password is incorrect']], 401);
        }

        return $this->createNewToken($token);
    }



    public function initiate_forgot_password_otp(Request $request){
        $phone_number = $request->phone_number;
        $sms = "1234";

        $resp = $this->send_message_sms($phone_number, $sms);
       if($resp['pinId']){
           return $resp;
           return response()->json([
            'message' => 'OTP sent',
            'otp' => $resp
        ], 200);
       } else {
           return $response->withStatus(500); // Not authorized
           $response = ["message"=>"Error sending OTP!"];
           return response($response, 500);
       }



    }



    public function forgotPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'new_password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::where('phone_number', $request->phone_number)->first();
        if(!empty($user)) {
            $user->password = bcrypt($request->new_password);
            if($user->save()){
                return response()->json(['errors' =>  [ 'message' => 'Password updated successfully!']], 200);
            }
        } else {
            return response()->json(['errors' =>  [ 'message' => 'Error updating password!']], 422);
        }
    }


    public function register(Request $request) {
        $sms = "";
        $request->email = strtolower($request->email);
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
            'validation_type' => 'required|string',
        ], [
            'firstname.required' => 'Text field cannot be empty, enter your first name',
            'lastname.required' => 'Text field cannot be empty, enter your last name',
            'email.required' => 'Text field cannot be empty, enter your email address',
            'email.email' => 'Enter a valid email address Ex. name@example.com',
            'email.unique' => 'Email address already exists',
            'phone_number.unique' => 'Phone number already exists',
            'phone_number.required' => 'Please enter your phone number',
            'username.required' => 'Text field cannot be empty, enter your Username',
            'password.required' => 'Text field cannot be empty, enter your password',
            'password.min' => 'Password must contain six or more characters',
            'validation_type.required' => 'Validation type is required',
        ]);
        if($validator->fails()){

            return response()->json(["error"=>"true", "message"=>$validator->errors()], 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password), 'userlevel' => 0]
                ));



        if($request->validation_type=="phone_sms"){
            $phone_number = $request->phone_number;
            $type = $request->type;
            $sms = $this->initiate_otp($phone_number, $type);
        }elseif($request->validation_type=="phone_voice"){
            $this->send_voice($request);
        }else{
           $code = rand(10000, 99999);

           Token::upsert([
            ['id' => generateUUID(), 'user_id' => $user->id, 'token' => $code]
        ], uniqueBy: ['user_id'], update: ['token']);

        Mail::send('emails.emailVerificationEmail', ['code' => $code, 'user' => $user], function($message) use($user){
              $message->to($user->email);
              $message->subject('Verify Email Address');
        });
        }


        // if($user->enable_app_notification) {
        //     createNotification($user->id, 'Welcome!. Thank you for joining us. Please visit your profile page to complete your account creation process.');
        // }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'sms' => $sms
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('api')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth('api')->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
          //  'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
    public function checkEmailExists(Request $request) {
        $request->merge(['email' => $request->route('email')]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if(User::where('email', $request->email)->exists()) {
            return response()->json(['message' =>  'Email address has been registered'], 422);
        } else {
            return response()->json(['message' => 'Email address has not been registered'], 201);
        }
   }


   function get_infobip_application(){
    //$qry = "SELECT * FROM infobip_app ORDER BY created_at ASC";
    $application = InfobipApp::orderBy('created_at', 'DESC')->first();
    return $application;
}

function create_infobip_application(){

    $uuid =  Str::uuid()->toString();
    $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => Config::get('app.infobip_url').'/2fa/2/applications',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"name":"Voice-OTP-'.$uuid.'","enabled":true,"configuration":{"pinAttempts":"10","allowMultiplePinVerifications":"true","pinTimeToLive":"15m","verifyPinLimit":"1/3s","sendPinPerApplicationLimit":"100/1d","sendPinPerPhoneNumberLimit":"10/1d"}}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App '.Config::get('app.infobip_api_key'),
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);

    if($response['applicationId']){
        $resp = json_decode($this->create_message_template($response['applicationId']), true);
        $response['template_id'] = $resp['messageId'];
        $response['application_id'] = $response['applicationId'];
        $this->save_infobip_application($uuid, $response);
    }

    return $response;
}

function save_infobip_application($response){
    // $max = $response['configuration']['sendPinPerApplicationLimit'];
    // $max = explode("/",$max);
    // $max = $max[0];
    // $days = $max[1];
    $infobip_app = new InfobipApp();
    //$infobip_app->id = $uuid;
    $infobip_app->application_id = $response['application_id'];
    $infobip_app->template_id = $response['template_id'];
    // $infobip_app->max = $max;
    // $infobip_app->day_limit = $days;
    $infobip_app->save();
    //$qry = "INSERT INTO infobip_app (id, application_id, template_id, max, day_limit, created_at, updated_at) VALUES ('".$uuid."', '".$response['applicationId']."','".$response['template_id']."',".$max.", ".$days.", now(), now())";
    return $infobip_app->save();
}

function update_sms_application($count, $appid){
    $qry = "UPDATE infobip_app SET call_count=".$count." WHERE application_id=".$appid;
    return ExecuteStatement($qry);
}



function create_message_template($appid){
    global $infobip_key;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => Config::get('app.infobip_url').'/2fa/2/applications/'.$appid.'/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"pinType":"NUMERIC","messageText":"Your pin is {{pin}}","pinLength":4,"language":"en","senderId":"D3 Store","repeatDTMF":"1#","speechRate":1}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: App '.Config::get('app.infobip_api_key'),
            'Content-Type: application/json',
            'Accept: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function send_message_sms($recepient, $sms){
    $sms_app = $this->get_infobip_application();
    $resp = 401;
    if($sms_app){
        $count = $sms_app['call_count'] + 1;
    }else{
        $sms_app = $this->create_infobip_application();
    }
    $app = $this->send_sms_request($recepient, $sms_app['application_id'], $sms_app['template_id']);

    $app = json_decode($app, true);
    return  $app;
}


function validate_otp($pin, $pin_id){

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => Config::get('app.infobip_url').'/2fa/2/pin/'.$pin_id.'/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"pin":"'.$pin.'"}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: App '.Config::get('app.infobip_api_key'),
            'Content-Type: application/json',
            'Accept: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
 }

function send_sms_request($recepient, $application_id, $message_id){
   $recepient = substr($recepient, 1);
   $curl = curl_init();
   curl_setopt_array($curl, array(
       CURLOPT_URL => Config::get('app.infobip_url').'/2fa/2/pin',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'POST',
       CURLOPT_POSTFIELDS =>'{"applicationId":"'.$application_id.'","messageId":"'.$message_id.'","from":"D3 Store","to":"'.$recepient.'"}',
       CURLOPT_HTTPHEADER => array(
           'Authorization: App '.Config::get('app.infobip_api_key'),
           'Content-Type: application/json',
           'Accept: application/json'
       ),
   ));
   $response = curl_exec($curl);
   curl_close($curl);

   return $response;
}

function send_sms($recepient, $sms){

   $message_status = 500;
   $configuration =  new Configuration(host: env('INFOBIP_BASE_URL'), apiKey: Config::get('app.infobip_api_key'));
   $sendSmsApi = new SmsApi(config: $configuration);
   $destination = new SmsDestination(
       to: $recepient
   );
   $message = new SmsTextualMessage(destinations: [$destination], from: env('INFOBIP_SENDER'), text: $sms);
   $request = new SmsAdvancedTextualRequest(messages: [$message]);
   try {
       $smsResponse = $sendSmsApi->sendSmsMessage($request);
       echo $smsResponse->getBulkId() . PHP_EOL;
       foreach ($smsResponse->getMessages() ?? [] as $message) {
           //echo sprintf('Message ID: %s, status: %s', $message->getMessageId(), $message->getStatus()?->getName()) . PHP_EOL;
           $message = $message->getStatus()?->getName();
           if($message=="PENDING_ACCEPTED"){
               $message_status=200;
           }
       }
   } catch (Throwable $apiException) {
       echo("HTTP Code: " . $apiException->getCode() . "\n");
   }
   return $message_status;
}



function get_stored_user_token($phone_number){
   global $front_end_url;
   $qry = "SELECT U.*, UT.token FROM user U INNER JOIN user_token UT ON U.id=UT.user_id WHERE U.phone_number='".$phone_number."'";
   $user = ExecuteRow($qry);
   if(!$user){
       return false;
   }
   $reset_link = $front_end_url."/new-password/?token=".$user['token'];
   $user['reset_link'] = $reset_link;
   return $user;
}

function get_user_details_from_stored_token($token){
   $qry = "SELECT U.* FROM user_token UT INNER JOIN user_user U ON UT.user_id=U.id WHERE UT.token='".$token."'";
   $user = ExecuteRow($qry);
   return $user;
}


function generateRandomNumber(){
   $FourDigitRandomNumber = mt_rand(1111,9999);
   return $FourDigitRandomNumber;
}

public function initiate_otp_validation(Request $request){

    $request->merge(['otp' => $request->route('otp'), 'pin_id' => $request->route('pin_id')]);
    $pin_id = $request->route('pin_id');
    $validator = Validator::make($request->all(), [
        'otp' => 'required|string',
        'pin_id' =>'required|string'
    ]);
    if ($validator->fails())
    {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
   return $this->validate_otp($request->otp, $request->pin_id);
}


public function initiate_otp($phone_number, $type){

   $sms= $this->generateRandomNumber();
   $exist_account = $this->check_account_exists($phone_number);

   if ($exist_account > 0) {
       $response = ["message"=>"User already validated","data"=>[]];
       return response($response, 400);
   }elseif($exist_account === 0) {

        $resp = $this->send_message_sms($phone_number, $sms);
       if($resp['pinId']){
        //    TempUser::create(['phone' => $phone_number, 'otp'=>$sms]);
        //    $payload = array('phone'=>$phone_number,'otp'=>$sms, 'exp'=>(time() + env('JWT_EXPIRY')));
        //    $token = $this->generate_custom_token($payload);
           return $resp;
       } else {
           return $response->withStatus(500); // Not authorized
           $response = ["message"=>"Error sending OTP!"];
           return response($response, 500);
       }
   }
}


public function request_otp(Request $request){
   $validator = Validator::make($request->all(), [
       'type' => 'required|string',
   ]);
   if ($validator->fails())
   {
       return response(['errors'=>$validator->errors()->all()], 422);
   }
   $phone_number = $request['phoneNumber']['countryCode'].$request['phoneNumber']['mobileNumber'];
   $type = $request['type'];
   $sms= $this->generateRandomNumber();

       if($type=="sms")
            $resp = $this->send_sms($phone_number, $sms);
       else
            $resp = $this->send_voice($phone_number, $sms);

       if($resp==200){
           TempUser::create(['phone' => $phone_number, 'otp'=>$sms]);
           $payload = array('phone'=>$phone_number,'otp'=>$sms, 'exp'=>(time() + env('JWT_EXPIRY')));
           $token = $this->generate_custom_token($payload);
           $response = ["token"=>$token, "message"=>"OTP sent to below number, kindly enter the 4-digit code in the box below!"];
           return response($response, 200);
       } else {
           return $response->withStatus(500); // Not authorized
           $response = ["message"=>"Error sending OTP!"];
           return response($response, 500);
       }

}


function send_voice($recepient, $sms){
    $voice_app = get_infobip_application();
    $resp = 401;
    if($voice_app && count($voice_app) > 0 && $voice_app['call_count'] < $voice_app['max']){
        $count = $voice_app['call_count'] + 1;
    }else{
        $voice_app = create_infobip_application();
    }
    $app = send_voice_request($recepient, $voice_app['application_id'], $voice_app['template_id']);
    $app = json_decode($app, true);
    if(isset($app['pinId'])){
        update_voice_application($count, $appid);
        $resp = 200;
    }
    return  $resp;
}

function send_voice_request($recepient, $application_id, $message_id){
   global $infobip_key;
   $recepient = substr($recepient, 1);
   $curl = curl_init();
   curl_setopt_array($curl, array(
       CURLOPT_URL => 'https://vjwewp.api.infobip.com/2fa/2/pin/voice',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'POST',
       CURLOPT_POSTFIELDS =>'{"applicationId":"'.$application_id.'","messageId":"'.$message_id.'","from":"D3 Store","to":"'.$recepient.'"}',
       CURLOPT_HTTPHEADER => array(
           'Authorization: App '.$infobip_key,
           'Content-Type: application/json',
           'Accept: application/json'
       ),
   ));
   $response = curl_exec($curl);
   curl_close($curl);
   return $response;
}


function generate_custom_token($payload){
   $headers = array('alg'=>'HS256','typ'=>'JWT');
   $jwt = generate_jwt($headers, $payload, env('JWT_SECRET'));
   return $jwt;
}


function validate_custom_token($token){
   return is_jwt_valid($token, env('JWT_SECRET'));
}

function check_account_exists($number){
   return User::where([
    ['phone_number',$number],
    ['validated',1]
])->count();
}

}
