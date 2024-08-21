<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    // Specify the table name if it does not follow Laravel's naming convention
    protected $table = 'post_categories';

    // Specify the primary key
    protected $primaryKey = 'term_id';

    // The primary key is non-incrementing or non-numeric if you have a custom primary key
    public $incrementing = true;
    
    // The data type of the primary key
    protected $keyType = 'unsignedBigInteger';

    // The attributes that are mass assignable
    protected $fillable = [
        'name', 'slug'
    ];

    // Disable timestamps if your table doesn't have 'created_at' and 'updated_at' columns
    public $timestamps = false;
}
