<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;

    protected $table = 'terms';

    protected $primaryKey = 'term_id';   

    public $incrementing = true;
    
    protected $keyType = 'unsignedBigInteger';

    protected $casts = [
        'term_id' => 'integer',
    ];

    protected $fillable = [
        'name', 'slug'
    ];

    public $timestamps = false;
}
