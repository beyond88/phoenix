<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;

class AddNew extends Component
{

    public $cats;

    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.add-new');
    }
}
