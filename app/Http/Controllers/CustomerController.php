<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CustomersInterface;
use App\Repositories\CustomersRepository;
USE App\Repositories\ProductsRepository;
use Validator;
use Log;

class CustomerController extends Controller
{
    private $customerRepository;
    private $productsRepository;
    private $request;

    public function __construct(CustomersRepository $customerRepository, ProductsRepository $productsRepository, Request $request)
    {
        $this->customerRepository =   $customerRepository;
        $this->productsRepository = $productsRepository;
        $this->request = $request;
    }

    public function getCustomerDetails(){

        validateUUID($this->request, "customer_id");
        return response()->json([ 'details' => $this->customerRepository->getCustomerDetails($this->request->customer_id) ], 201);
    }

    public function getCustomerCart(){
        $custValidation = validateUUID($this->request->all(), 'customer_id');
        if($custValidation!==true){
            return response()->json($custValidation, 422);
        }
        return response()->json([ 'data' => $this->customerRepository->getCustomerCart($this->request->customer_id) ], 201);
    }

    public function getCustomerOrders(){
        $custValidation = validateUUID($this->request->all(), 'customer_id');
        if($custValidation!==true){
            return response()->json($custValidation, 422);
        }
        return response()->json([ 'data' => $this->customerRepository->getCustomerOrders($this->request->customer_id) ], 201);
    }

    public function getCustomerOrder(){
        $custValidation = validateUUID($this->request->all(), 'customer_id');
        if($custValidation!==true){
            return response()->json($custValidation, 422);
        }
        return response()->json([ 'data' => $this->customerRepository->getCustomerOrder($this->request->order_id) ], 201);

    }


    public function createCustomerCart(){

        $custValidation = validateUUID($this->request->all(), 'customer_id');
       // $productsValidation = validateArrayType($this->request->all(), 'cart_products');

        if($custValidation!==true){
            return response()->json($custValidation, 422);
        }
        // if($productsValidation!==true){
        //     return response()->json($productsValidation, 422);
        // }

        // foreach($this->request->cart_products as $product){
        //     Log::info($product);
        //     $prdtValidation = validateUUID(["cart_products"=>$product->id], 'cart_products');
        //     if($prdtValidation!==true){
        //         return response()->json($prdtValidation, 422);
        //     }
        // }


        return response()->json([ 'data' => $this->customerRepository->createCustomerCart($this->request->all()) ], 201);
    }


    public function createCustomerOrder(){

        $custValidation = validateUUID($this->request->all(), 'customer_id');
        $cartIdValidation = validateUUID($this->request->all(), 'cart_id');
        $productsValidation = validateArrayType($this->request->all(), 'cart_details');
        $amountValidation = validateDoubleType($this->request->all(), 'amount');
        $paymentTypeValidation = validateStringType($this->request->all(), 'payment_type');

        $collection = collect($this->request->cart_details);
        $cart_products = $collection->pluck('product_id')->all();

        if($amountValidation!==true){
            return $amountValidation;
        }


        foreach($cart_products as $product){
            $prdtValidation = validateUUID(["cart_products"=>$product], 'cart_products');
            if($prdtValidation!==true){
                return response()->json($prdtValidation, 422);
            }
        }


        if(!$this->customerRepository->checkCustomer($this->request->customer_id)){
            return response()->json([ 'message' => "Customer not found" ], 400);
        }

        if(!$this->customerRepository->checkCart($this->request->cart_id)){
            return response()->json([ 'message' => "Cart details not found" ], 400);
        }


        if(!$this->productsRepository->checkProducts($cart_products)){
            return response()->json([ 'message' => "One or more of the specified products not found" ], 400);
        }

        return response()->json([ 'data' => $this->customerRepository->createCustomerOrder($this->request->all()) ], 201);
    }

    public function initializePaystackPayment(){
        $orderIdValidation = validateUUID($this->request->all(), 'order_id');
        $amountValidation = validateDoubleType($this->request->all(), 'amount');
        $emailTypeValidation = validateStringType($this->request->all(), 'email');


        if($amountValidation!==true){
            return $amountValidation;
        }
        return  $this->customerRepository->intializePayStackPayment($this->request->order_id, $this->request->email,$this->request->amount);
    }

    public function updatePaystackInitialization(){
        $orderIdValidation = validateUUID($this->request->all(), 'order_id');
        return  $this->customerRepository->updatePaystackPayment($this->request->order_id);
    }

}
