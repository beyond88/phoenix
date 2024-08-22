<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;

class Posts extends Component
{

    public $cats; 
    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.posts');
    }
}
