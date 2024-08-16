<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMetaLookup extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'product_meta_lookup';

    // The primary key associated with the table.
    protected $primaryKey = 'product_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = false;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'product_id',
        'product_or_parent_id',
        'stock_quantity',
        'min_price',
        'max_price',
        'onsale_from',
        'onsale_to',
        'stock_status',
        'tax_class_id',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'onsale_from' => 'integer',
        'onsale_to' => 'integer',
        'stock_status' => 'integer',
        'tax_class_id' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
