<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\PostCategory;
use App\Services\CategoryService;
use App\Services\MessageService;

class Categories extends Component
{

    public $cats;

    public $name; 

    public $slug; 

    public $termId; 

    public $updateCat = false; 

    public $addCat = false;

    protected $listeners = [
        'deleteCatListner' => 'deleteCat'
    ];

    protected $rules = [
        'name' => 'required',
    ];

    protected $categoryService;

    protected $messageService;

    public function __construct() 
    {
        $this->categoryService = app(CategoryService::class);
        $this->messageService = app(MessageService::class);
    }

    public function mount() 
    {
        $this->loadCategories();
    }

    private function loadCategories()
    {
        $this->cats = $this->categoryService->getAllCategories();
    }

    public function render()
    {
        $this->loadCategories();
        return view('livewire.posts.categories');
    }

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
            $this->slug = $this->categoryService->textUpperToLower($this->name);
        } else {
            $this->slug = $this->categoryService->textUpperToLower($this->slug);
        }

        $this->slug = $this->categoryService->generateUniqueSlug($this->slug);

        try {
            $this->categoryService->create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            $this->messageService->message('success', 'Category Created Successfully!');
            $this->resetFields();
            $this->addCat = false;
        } catch (\Exception $ex) {
            $this->messageService->message('error', 'Something went wrong!!');
        }
    }

    public function editCategory($id)
    {
        try {
            $category = $this->categoryService->editCategory($id);
            if (!$category) {
                $this->messageService->message('error', 'Category not found');
            } else {
                $this->name = $category->name;
                $this->slug = $category->slug;
                $this->termId = $category->term_id;
                $this->updateCat = true;
                $this->addCat = false;
            }
        } catch (\Exception $ex) {
            $this->messageService->message('error', 'Something went wrong!!');
        }
    }

    public function updateCategory()
    {
        $this->validate();
        try {

            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
                'term_id' => $this->termId
            ];
            $result = $this->categoryService->updateCategory($data);

            if ($this->messageService->isActionSuccessful($result)) {
                $this->messageService->message('success', 'Category Updated Successfully!');
                $this->resetFields();
                $this->updateCat = false;
                $this->loadCategories();
            } else {
                $this->messageService->message('error', 'Something went wrong!');
            }
            $this->resetFields();
            $this->updateCat = false;
        } catch (\Exception $ex) {
            $this->messageService->message('error', 'Something went wrong!');
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
            $result = $this->categoryService->deleteCategory($id);
            if ($this->messageService->isActionSuccessful($result)) {
                $this->loadCategories();
               $this->messageService->message('success', "Category Deleted Successfully!");
            } else {
                $this->messageService->message('error', $result['message']);
            }
        } catch (\Exception $e) {
            $this->messageService->message('error', "Something went wrong!!");
        }
    }
}
