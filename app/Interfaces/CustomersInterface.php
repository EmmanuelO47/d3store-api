<?php

namespace App\Interfaces;

interface CustomersInterface
{
    public function getCustomerDetails($customer_id);
    public function getCustomerCart($customer_id);
    public function getCustomerOrders($customer_id);
    public function getCustomerOrder($order_id);

    public function createCustomerOrder($data);
    public function createCustomerCart($data);
    public function deleteCart($cart_id);
    public function createCustomerComplaint($data);
    

}
