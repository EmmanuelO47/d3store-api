<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class InfobipApp extends Model
{
    use HasFactory;
    protected $table = 'infobip_app';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    use HasUuids;
     protected $fillable = [
         'application_id',
         'template_id',
         'max',
         'day_limit',
         'call_count',
     ];
}
