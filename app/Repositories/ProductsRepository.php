<?php

namespace App\Repositories;
use App\Interfaces\ProductsInterface;
use App\Models\Product;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ProductsRepository.
 */
class ProductsRepository extends BaseRepository implements ProductsInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Product::class;
    }

    public function getProductDetails($product_id){
        return Product::where('id',$product_id)->get();
    }
    public function getStoreProducts($store_id){
        return Product::where('store_id',$store_id)->get();
    }
    public function checkProducts($productIds){
        $foundProducts = Product::whereIn('id', $productIds)->pluck('id')->toArray();
        $allFound = empty(array_diff($productIds, $foundProducts));
        return $allFound;
    }

    public function createStoreProduct($data){
        $product = Product::create(["name"=>$data['name'], "description"=>$data['name'],"product_code"=>$data['name'], "product_image"=>$data['name'],"price"=>$data['name'], "quantity"=>$data['name'], "category_id"=>$data['name'],"store_id"=>$data['name']]);
    }

    
    public function updateStoreProduct($data){

    }



}
