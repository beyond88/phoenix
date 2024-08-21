<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;

class Categories extends Component
{
    public $cats, $name, $slug, $termId, $updateCat = false, $addCat = false;

    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.categories');
    }

    /**
     * Delete action listener
     */
    protected $listeners = [
        'deleteCatListner' => 'deleteCat'
    ];

    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'name' => 'required',
        'slug' => 'required'
    ];

    /**
     * Resetting all inputted fields
     * @return void
     */
    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->termId = null;
    }

    /**
     * Open Add Category form
     * @return void
     */
    public function addCategory()
    {
        $this->resetFields();
        $this->addCat = true;
        $this->updateCat = false;
    }

    /**
     * Store the user inputted category data in the categories table
     * @return void
     */
    public function storeCat()
    {
        $this->validate();
        try {
            PostCategory::create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            session()->flash('success', 'Category Created Successfully!!');
            $this->resetFields();
            $this->addCat = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    /**
     * Show existing category data in edit category form
     * @param mixed $id
     * @return void
     */
    public function editCat($id)
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

    /**
     * Update the category data
     * @return void
     */
    public function updateCat()
    {
        $this->validate();
        try {
            PostCategory::where('term_id', $this->termId)->update([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            session()->flash('success', 'Category Updated Successfully!!');
            $this->resetFields();
            $this->updateCat = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something went wrong!!');
        }
    }

    /**
     * Cancel Add/Edit form and reset fields
     * @return void
     */
    public function cancelCat()
    {
        $this->addCat = false;
        $this->updateCat = false;
        $this->resetFields();
    }

    /**
     * Delete specific category data from the categories table
     * @param mixed $id
     * @return void
     */
    public function deleteCat($id)
    {
        try {
            PostCategory::find($id)->delete();
            session()->flash('success', "Category Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong!!");
        }
    }
}
