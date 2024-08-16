<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadableProductPermission extends Model
{
    use HasFactory;

     // Specify the table name if it's different from the default plural form
     protected $table = 'downloadable_product_permissions';

     // The primary key associated with the table.
     protected $primaryKey = 'permission_id';
 
     // Indicates if the primary key is auto-incrementing.
     public $incrementing = true;
 
     // The "type" of the auto-incrementing ID.
     protected $keyType = 'int';
 
     // The attributes that are mass assignable.
     protected $fillable = [
         'download_id',
         'product_id',
         'order_id',
         'order_key',
         'user_email',
         'user_id',
         'downloads_remaining',
         'access_granted',
         'access_expires',
         'download_count',
     ];
 
     // The attributes that should be cast to native types.
     protected $casts = [
         'access_granted' => 'datetime',
         'access_expires' => 'datetime',
         'downloads_remaining' => 'string',
         'download_count' => 'integer',
         'order_id' => 'integer',
         'product_id' => 'integer',
         'user_id' => 'integer',
     ];
 
     // Disable timestamps if not used
     public $timestamps = false;
}
