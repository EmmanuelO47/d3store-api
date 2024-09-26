<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'product_code',
        'product_image',
        'price',
        'quantity',
        'category_id',
        'store_id',
        'phone',
        'account_number',
        'bank',
        'account_number',
    ];

    public function productShares()
    {
        return $this->hasMany(productShare::class, 'product_id', 'id');
    }
}
