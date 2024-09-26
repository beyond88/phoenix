<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermRelationship extends Model
{
    use HasFactory;

    protected $table = 'term_relationships';
    protected $primaryKey = 'object_id'; // Assuming 'object_id' is your primary key
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'object_id',
        'term_taxonomy_id',
    ];
}