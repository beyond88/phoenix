<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'tax_rates';

    // The primary key associated with the table.
    protected $primaryKey = 'tax_rate_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'tax_rate_country',
        'tax_rate_state',
        'tax_rate',
        'tax_rate_name',
        'tax_rate_priority',
        'tax_rate_compound',
        'tax_rate_shipping',
        'tax_rate_order',
        'tax_rate_class',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'tax_rate_compound' => 'boolean',
        'tax_rate_shipping' => 'boolean',
        'tax_rate_priority' => 'integer',
        'tax_rate_order' => 'integer',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
