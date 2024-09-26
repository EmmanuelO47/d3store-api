<?php
namespace App\Http\Controllers\documentation;
use App\Http\Controllers\Controller;

class SwaggerAuthController extends Controller
{

/**
 * @OA\Post(
 *     path="/v1/auth/regiser",
 *     summary="New Registration",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="firstname_in_query",
 *       name="firstname",
 *       description="The user firstname",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="lastname_in_query",
 *       name="lastname",
 *       description="User lastname",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="phone_number_in_query",
 *       name="phone_number",
 *       description="User Phone Number",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="email_in_query",
 *       name="email",
 *       description="User email",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="username_in_query",
 *       name="username",
 *       description="username",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="password_in_query",
 *       name="password",
 *       description="password",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="validation_type_in_query",
 *       name="validation_type",
 *       description="validation_type",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */

public  function register(Request $request){

}

/**
 * @OA\Get(
 *     path="/v1/auth/email/verify/{id}/{hash}",
 *     summary="Verify user email",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="id_in_path",
 *       name="id",
 *       description="The user id",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="path",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="hash_in_path",
 *       name="hash",
 *       description="The generated hash",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="path",
 *      required=true
 *     )
 * )
 */

 public function verify(Request $request){}

/**
 * @OA\Post(
 *     path="/v1/auth/reset-password",
 *     summary="Reset User Password",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="id_in_query",
 *       name="id",
 *       description="The user id",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="hash_in_query",
 *       name="hash",
 *       description="The generated hash",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="password_in_query",
 *       name="password",
 *       description="New Password",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */
public function resetPassword(Request $request){}

 /**
 * @OA\Post(
 *     path="/v1/auth/login",
 *     summary="Login",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="email_in_query",
 *       name="email",
 *       description="The user email",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="password_in_query",
 *       name="password",
 *       description="New Password",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */

 public function login(Request $request){}

/**
 * @OA\Post(
 *     path="/v1/auth/forgot-password/otp",
 *     summary="Forot password via OTP",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="phone_number_in_query",
 *       name="phone_number",
 *       description="The user phone_number",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */
public function initiate_forgot_password_otp(Request $request){}

/**
 * @OA\Post(
 *     path="/v1/auth/forgot-password",
 *     summary="Forot password",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="phone_number_in_query",
 *       name="phone_number",
 *       description="The user phone_number",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="new_password_in_query",
 *       name="new_password",
 *       description="New Password",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */

 public function forgotPassword(Request $request){}

 /**
 * @OA\Post(
 *     path="/v1/auth/check-email-exists",
 *     summary="Check if email exists",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="email_in_path",
 *       name="email",
 *       description="The user email",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="path",
 *      required=true
 *     )
 * )
 */

 public function checkEmailExists(Request $request){}

 /**
 * @OA\Post(
 *     path="/v1/auth/logout",
 *     summary="Logout of application",
 *     tags={"Auth"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request")
 * )
 */

 public function logout(Request $request){}


}
