<?php

namespace App\Repositories;
use App\Interfaces\CustomersInterface;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PaystackPayment;
use App\Models\Cart;
use App\Models\Product;
use Log;

/**
 * Class CustomersRepository.
 */
class CustomersRepository extends BaseRepository implements CustomersInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Customer::class;
    }

    public function getCustomerDetails($customer_id){
        return Customer::with('user')->where('id',$customer_id)->get();
    }

    public function checkCustomer($customer_id){
        if(!Customer::where('id',$customer_id)->exists()){
            return false;
        }
        return true;
    }

    public function checkCart($cart_id){
        if(!Cart::where('id',$cart_id)->exists()){
            return false;
        }
        return true;
    }


    public function checkProducts($products){
        if(!Customer::where('id',$customer_id)->exists()){
            return false;
        }
        return true;
    }

    public function getCustomerCart($customer_id){
        $cart = Cart::where('customer_id', $customer_id)->get()[0];
        $cart_products =  array_column($cart->cart_products, 'id');


        $products = Product::whereIn('id',$cart_products)->get();
        $prdts = $products->map(function($product) use($cart){
                    collect($cart->cart_products)->map(function($cart_product) use($product){
                        $cart_prdt = (object)$cart_product;
                        if($product->id==$cart_prdt->id){
                            unset($product->quantity);
                            $product->quantity = $cart_prdt->quantity;
                        }
                    });
                    return $product;
                });
        unset($cart->cart_products);
        $cart->products = $prdts;
        return $cart;
    }

    public function getCustomerOrders($customer_id){
        return Customer::with('orders')->where('id',$customer_id)->get();
    }
    public function getCustomerOrder($order_id){
        return Order::with('details')->where('id', $order_id);
    }

    public function createCustomerOrder($data){
        $order = Order::Create(["customer_id"=>$data['customer_id'], "amount"=>$data['amount'], "payment_type"=>$data['payment_type'], "payment_status"=>"UNPAID", "status"=>"PENDING_PAYMENT"]);
        //$order_details = $this->getCustomerCart(data['customer_id']);
        $customer_order = $this->createOrderDetails($order['id'], $data['cart_details']);
        $this->deleteCartDetails($data['cart_id']);
        return $customer_order;
    }

    private function createOrderDetails($order_id, $details){
        $data = [];
        foreach($details as $detail){
            $data[] = ["id"=>generateUUID(), "order_id"=>$order_id, "product_id"=>$detail['product_id'], "quantity"=>$detail['quantity'], "price"=>$detail['price']];
        }

        $details = OrderDetails::insert($data);
        return $data;
    }

    public function deleteCart($cart_id){
        $this->deleteCartDetails($cart_id);
    }

    private function deleteCartDetails($cart_id){
        return Cart::where("id", $cart_id)->delete();
    }
    public function createCustomerCart($data){

        $cart = Cart::updateOrCreate(
            ["customer_id"=>$data['customer_id']],
            ["cart_products"=>$data['cart_products']]
        );

        return $cart;

    }

    public function intializePayStackPayment($order_id, $email,$amount){
        $details = $this->getPaystackPayment($order_id)[0];
        if(isset($details['valid']) && $details['valid']==true){
            return $details;
        }


        $result = initiate_payment($email, $amount);
        $payment_data = json_decode($result, true);
        if($payment_data['status']==true){
            $data = [];
        $data[] = ["id"=>generateUUID(), "order_id"=>$order_id, "authorization_url"=>$payment_data['data']['authorization_url'], "access_code"=>$payment_data['data']['access_code'], "reference"=>$payment_data['data']['reference'], "valid"=>true];
        $details = PaystackPayment::insert($data);
        return $data;

        }else{
            return $result['status'];
        }


    }

    public function getPaystackPayment($order_id){
        return PaystackPayment::where(["order_id"=>$order_id, "valid"=>true])->get();
    }

    public function updatePaystackPayment($order_id){
       $paystack_payment = PaystackPayment::where(["order_id"=>$order_id, "valid"=>true])->update(["valid"=>false]);
    }
    public function createCustomerComplaint($data){

    }




}
