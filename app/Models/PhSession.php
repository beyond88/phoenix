<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhSession extends Model
{
    // Explicitly specify the table name
    protected $table = 'ph_sessions';

    // Define the primary key
    protected $primaryKey = 'session_id';

    // If the primary key is auto-incrementing
    public $incrementing = true;

    // Define the primary key type
    protected $keyType = 'int';

    // Disable timestamps if the table doesn't have `created_at` and `updated_at` columns
    public $timestamps = false;

    // Define the fillable attributes
    protected $fillable = [
        'session_key',
        'session_value',
        'session_expiry',
    ];

    // If necessary, define any relationships, accessors, or mutators
}

