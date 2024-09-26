<?php
namespace App\Http\Controllers\documentation;
use App\Http\Controllers\Controller;

class SwaggerStoreController extends Controller
{

    /**
     * @OA\Get(
     *     path="/v1/stores/list/",
     *     summary="Get stores list based on location id",
     *     tags={"Store"},
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

    public function getStores(Request $request){}

    /**
     * @OA\Get(
     *     path="/v1/stores/products/",
     *     summary="Get store products based on store id",
     *     tags={"Store"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request"),
     *     @OA\Parameter(
     *       parameter="store_id_in_path",
     *       name="store_id",
     *       description="The store id",
     *      @OA\Schema(
     *        type="string"
     *       ),
     *      in="path",
     *      required=true
     *     )
     * )
     */

     public function getStoreProducts(Request $request){}
}
