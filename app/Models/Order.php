<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'amount',
        'status',
        'payment_type',
        'payment_status',
    ];


    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

}
