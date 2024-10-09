<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermRelationship extends Model
{
    use HasFactory;

    protected $table = 'term_relationships';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'object_id',
        'term_taxonomy_id',
    ];
}