<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Specify the table if not using Laravel's convention
    protected $table = 'posts';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'post_title',
        'post_content',
        'post_status',
        'category_id',
        'media_id',
        'user_id',
    ];

    // Optional: Specify any additional attributes or methods if needed
}

