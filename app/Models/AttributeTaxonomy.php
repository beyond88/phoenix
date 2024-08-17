<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeTaxonomy extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default plural form
    protected $table = 'attribute_taxonomies';

    // The primary key associated with the table.
    protected $primaryKey = 'attribute_id';

    // Indicates if the primary key is auto-incrementing.
    public $incrementing = true;

    // The "type" of the auto-incrementing ID.
    protected $keyType = 'int';

    // The attributes that are mass assignable.
    protected $fillable = [
        'attribute_name',
        'attribute_label',
        'attribute_type',
        'attribute_orderby',
        'attribute_public',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'attribute_public' => 'boolean',
    ];

    // Disable timestamps if not used
    public $timestamps = false;
}
