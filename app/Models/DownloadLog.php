<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'download_log';

    // The primary key associated with the table.
    protected $primaryKey = 'download_log_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'timestamp',
        'permission_id',
        'user_id',
        'user_ip_address',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'timestamp' => 'datetime',
        'user_id' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
