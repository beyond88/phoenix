<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'shipping_zones';

    // The primary key associated with the table.
    protected $primaryKey = 'zone_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'zone_name',
        'zone_order',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
