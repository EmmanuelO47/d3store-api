<?php

namespace App\Interfaces;

interface ProductsInterface
{
    public function getProductDetails($product_id);
    public function getStoreProducts($store_id);
    public function checkProducts($products);

    public function createStoreProduct($data);
    public function updateStoreProduct($data);
}
