<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaystackPayment extends Model
{
    use HasFactory;
    protected $table = 'paystack_payments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;

    protected $fillable = [
        'order_id',
        'authorization_url',
        'access_code',
        'reference'
    ];
}
