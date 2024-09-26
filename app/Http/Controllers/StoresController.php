<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StoresRepository;
use App\Interfaces\StoresInterface;
use Log;
use Validator;

class StoresController extends Controller
{
    private $storesRepository;
    private $request;

    public function __construct(StoresRepository $storesRepository,Request $request)
    {
        $this->storesRepository =  $storesRepository;
        $this->request = $request;
    }

    public function getStores(){
        $chkValidation = validateUUID($this->request, 'location_id');
        if($chkValidation!==true){
            return response()->json($chkValidation, 422);
        }
        return response()->json([ 'Stores' => $this->storesRepository->getStores($this->request->location_id) ], 201);
    }

    public function getStoreProducts(){

        $chkValidation = validateUUID($this->request, 'store_id');

        if($chkValidation!==true){
            return response()->json($chkValidation, 422);
        }

        return response()->json([ 'Products' => $this->storesRepository->getStoreProducts($this->request->store_id, $this->request->pagination_data) ], 201);
    }

    public function getProductShares(){
        return response()->json([ 'Products' => $this->storesRepository->getProductShares($this->request->pagination_data) ], 201);
    }
}
