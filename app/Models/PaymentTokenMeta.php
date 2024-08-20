<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTokenMeta extends Model
{
    use HasFactory;

     // Specify the table name if it's different from the default plural form
     protected $table = 'payment_tokenmeta';

     // The primary key associated with the table.
     protected $primaryKey = 'meta_id';
 
     // Indicates if the primary key is auto-incrementing.
     public $incrementing = true;
 
     // The "type" of the auto-incrementing ID.
     protected $keyType = 'int';
 
     // The attributes that are mass assignable.
     protected $fillable = [
         'payment_token_id',
         'meta_key',
         'meta_value',
     ];
 
     // Disable timestamps if not used
     public $timestamps = false;
}
