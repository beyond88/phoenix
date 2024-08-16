<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentToken extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'payment_tokens';

    // The primary key associated with the table.
    protected $primaryKey = 'token_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'gateway_id',
        'token',
        'user_id',
        'type',
        'is_default',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'is_default' => 'boolean',
        'user_id' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
