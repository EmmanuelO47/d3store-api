<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;
    protected $fillable = [
        'name',
        'address',
        'state',
        'city',
        'location',
        'email',
        'contact_person',
        'phone',
        'account_number',
        'bank',
        'account_number',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'store_id','id');
    }
}
