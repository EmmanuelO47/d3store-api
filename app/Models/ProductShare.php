<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class productShare extends Model
{
    use HasFactory;
    protected $table = 'product_share';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;


    public function products()
    {
        return $this->hasOne(product::class, 'id', 'product_id');
    }
}
