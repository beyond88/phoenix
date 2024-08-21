<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;


class Categories extends Component
{

    public $name, $slug, $termId, $updateCat = false, $addCat = false;

    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.categories');
    }

    /**
     * delete action listener
     */
    protected $listeners = [
        'deleteCatListner'=>'deleteCat'
    ];
 
    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'name' => 'required',
        'slug' => 'required'
    ];
 
    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields(){
        $this->name = '';
        $this->slug = '';
    }
 
    /**
     * Open Add Post form
     * @return void
     */
    public function addPost()
    {
        $this->resetFields();
        $this->addCat = true;
        $this->updateCat = false;
    }
     /**
      * store the user inputted post data in the posts table
      * @return void
      */
    public function storeCat()
    {
        $this->validate();
        try {
            Posts::create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            session()->flash('success','Category Created Successfully!!');
            $this->resetFields();
            $this->addCat = false;
        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!');
        }
    }
 
    /**
     * show existing post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function editCat($id) 
    {
        try {
            $post = PostCategory::findOrFail($id);
            if( !$post) {
                session()->flash('error','Post not found');
            } else {
                $this->name = $post->name;
                $this->slug = $post->slug;
                $this->termId = $post->term_id;
                $this->updateCat = true;
                $this->addCat = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!');
        }
 
    }
 
    /**
     * update the post data
     * @return void
     */
    public function updateCat()
    {
        $this->validate();
        try {
            Posts::whereId($this->termId)->update([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            session()->flash('success','Category Updated Successfully!!');
            $this->resetFields();
            $this->updateCat = false;
        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }
 
    /**
     * Cancel Add/Edit form and redirect to post listing page
     * @return void
     */
    public function cancelCat()
    {
        $this->addCat = false;
        $this->updateCat = false;
        $this->resetFields();
    }
 
    /**
     * delete specific post data from the categories table
     * @param mixed $id
     * @return void
     */
    public function deleteCat($id)
    {
        try{
            PostCategory::find($id)->delete();
            session()->flash('success',"Category Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }
    }

}
