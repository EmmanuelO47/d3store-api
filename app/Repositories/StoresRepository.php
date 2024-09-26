<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Interfaces\StoresInterface;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductShare;
use Log;
/**
 * Class StoresRepository.
 */
class StoresRepository extends BaseRepository implements StoresInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Store::class;
    }

    public function getStores($location_id){
        //  return Store::with(['products' => function($query){
        //     $query->paginate(10);
        //  }])->where('location', $location_id);
        $new_stores = [];
        $stores = Store::where('location', $location_id)->get();
        foreach($stores as $store){
            $store->products = $this->getEachStoreProducts($store->id);
            Log::info($store);
            $new_stores[] = $store;
        }


       return $new_stores;
    }

    function getEachStoreProducts($store_id){
        return Product::where('store_id', $store_id)->paginate(10)->withPath('/api/stores/products');
    }

    public function getProductShares(){
        return ProductShare::with('Products')->paginate(10);
    }

    public function getStoreProducts($store_id, $pagination_data){
        return Product::where('store_id', $store_id)->paginate(10);
    }
}
