<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class Categories extends Component
{
    public $cats, $name, $slug, $termId, $updateCat = false, $addCat = false;

    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.categories');
    }    

    protected $listeners = [
        'deleteCatListner' => 'deleteCat'
    ];

    protected $rules = [
        'name' => 'required',
    ];

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->termId = null;
    }

    public function addCategory()
    {
        $this->resetFields();
        $this->addCat = true;
        $this->updateCat = false;
    }

    public function storeCategory()
    {
        $this->validate();

        if (empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        } else {
            $this->slug = Str::slug($this->slug);
        }

        $this->slug = $this->generateUniqueSlug($this->slug);

        try {
            PostCategory::create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            session()->flash('success', 'Category Created Successfully!');
            $this->resetFields();
            $this->addCat = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    public function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        while (PostCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function editCategory($id)
    {
        try {
            $category = PostCategory::findOrFail($id);
            if (!$category) {
                session()->flash('error', 'Category not found');
            } else {
                $this->name = $category->name;
                $this->slug = $category->slug;
                $this->termId = $category->term_id;
                $this->updateCat = true;
                $this->addCat = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    public function updateCategory()
    {
        $this->validate();
    
        // Fetch the current category from the database
        $currentCategory = PostCategory::find($this->termId);
    
        // Check if the slug field is empty
        if (empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        } else {
            $this->slug = Str::slug($this->slug);
        }
    
        // If the slug has changed, generate a unique slug
        if ($this->slug !== $currentCategory->slug) {
            $this->slug = $this->generateUniqueSlug($this->slug, $this->termId);
        }
    
        try {
            // Update the category with the new name and slug
            PostCategory::where('term_id', $this->termId)->update([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
    
            session()->flash('success', 'Category Updated Successfully!');
            $this->resetFields();
            $this->updateCat = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!');
        }
    }    

    public function cancelCategory()
    {
        $this->addCat = false;
        $this->updateCat = false;
        $this->resetFields();
    }

    public function deleteCategory($id)
    {
        try {
            PostCategory::find($id)->delete();
            session()->flash('success', "Category Deleted Successfully!");
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong!!");
        }
    }
}
