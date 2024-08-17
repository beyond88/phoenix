<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'webhooks';

    // The primary key associated with the table.
    protected $primaryKey = 'webhook_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'status',
        'name',
        'user_id',
        'delivery_url',
        'secret',
        'topic',
        'date_created',
        'date_created_gmt',
        'date_modified',
        'date_modified_gmt',
        'api_version',
        'failure_count',
        'pending_delivery',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'date_created' => 'datetime',
        'date_created_gmt' => 'datetime',
        'date_modified' => 'datetime',
        'date_modified_gmt' => 'datetime',
        'failure_count' => 'integer',
        'pending_delivery' => 'boolean',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
