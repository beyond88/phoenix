<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'log';

    // The primary key associated with the table.
    protected $primaryKey = 'log_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'timestamp',
        'level',
        'source',
        'message',
        'context',
    ];

    // Casts for the attributes
    protected $casts = [
        'timestamp' => 'datetime',
        'level' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
