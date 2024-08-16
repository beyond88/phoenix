<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'order_items';

    // The primary key associated with the table.
    protected $primaryKey = 'order_item_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'order_item_name',
        'order_item_type',
        'order_id',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
