<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRateClass extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'tax_rate_classes';

    // The primary key associated with the table.
    protected $primaryKey = 'tax_rate_class_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
