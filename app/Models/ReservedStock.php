<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedStock extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'reserved_stock';

    // The primary key associated with the table.
    protected $primaryKey = 'stock_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'timestamp',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'quantity' => 'integer',
        'timestamp' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
