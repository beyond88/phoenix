<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZoneMethod extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'shipping_zone_methods';

    // The primary key associated with the table.
    protected $primaryKey = 'instance_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'zone_id',
        'method_id',
        'method_order',
        'is_enabled',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'is_enabled' => 'boolean',
        'method_order' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
