<?php

namespace App\Interfaces;

interface StoresInterface
{
    public function getStores($location_id);
    public function getStoreProducts($store_id, $pagination_data);
    public function getProductShares();

}
