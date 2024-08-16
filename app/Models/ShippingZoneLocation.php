<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZoneLocation extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'shipping_zone_locations';

    // The primary key associated with the table.
    protected $primaryKey = 'location_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'zone_id',
        'location_code',
        'location_type',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
