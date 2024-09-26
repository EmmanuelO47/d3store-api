<?php
namespace App\Http\Controllers\documentation;
use App\Http\Controllers\Controller;

class SwaggerCustomerController extends Controller
{

    /**
     * @OA\Get(
     *     path="/v1/customer/details/",
     *     summary="Get stores list based on location id",
     *     tags={"Customer"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request"),
     *     @OA\Parameter(
     *       parameter="location_id_in_path",
     *       name="location_id",
     *       description="The location id",
     *      @OA\Schema(
     *        type="string"
     *       ),
     *      in="path",
     *      required=true
     *     )
     * )
     */

    public function getCustomerDetails(Request $request){}

    /**
     * @OA\Get(
     *     path="/v1/customer/cart/",
     *     summary="Get customer cart details based on customer id",
     *     tags={"Customer"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request"),
     *     @OA\Parameter(
     *       parameter="customer_id_in_path",
     *       name="customer_id",
     *       description="The customer id",
     *      @OA\Schema(
     *        type="string"
     *       ),
     *      in="path",
     *      required=true
     *     )
     * )
     */

     public function getCustomerCart(Request $request){}

    /**
 * @OA\Post(
 *     path="/v1/customer/create-cart",
 *     summary="LoginCreate customer cart",
 *     tags={"Customer"},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Parameter(
 *       parameter="customer_id_in_query",
 *       name="customer_id",
 *       description="The customer id",
 *      @OA\Schema(
 *        type="string"
 *       ),
 *      in="query",
 *      required=true
 *     ),
 *  @OA\Parameter(
 *       parameter="cart_products_in_query",
 *       name="cart_products",
 *       description="Array list of product ids",
 *      @OA\Schema(
 *        type="array",
 *        @OA\Items(type="string"),
 *        example={"52f2e026-a99a-41ec-93b0-e950fb65d137", "fc162fb5-88ce-4e9e-ae43-1c12aa8732cf"}
 *       ),
 *      in="query",
 *      required=true
 *     )
 * )
 */

 public function createCustomerCart(Request $request){}
}

