<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class SMSApplication extends Model
{
    use HasFactory;
    protected $table = 'infobip_app';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasUuids;
}
