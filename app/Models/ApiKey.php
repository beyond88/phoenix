<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    // Explicitly specify the table name
    protected $table = 'api_keys';

    // Define the primary key
    protected $primaryKey = 'key_id';

    // If the primary key is auto-incrementing
    public $incrementing = true;

    // Define the primary key type
    protected $keyType = 'int';

    // Disable timestamps if the table doesn't have `created_at` and `updated_at` columns
    public $timestamps = false;

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'description',
        'permissions',
        'consumer_key',
        'consumer_secret',
        'nonces',
        'truncated_key',
        'last_access',
    ];

    // Define any casts if necessary
    protected $casts = [
        'last_access' => 'datetime',
    ];
}
