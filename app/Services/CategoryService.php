<?php

namespace App\Services;

use App\Models\PostCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategoryService extends Controller
{

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

    public function textUpperToLower($text)
    {
        return Str::slug($text);
    }

    public function getAllCategories()
    {
        return PostCategory::select('post_categories.term_id', 'post_categories.name', 'post_categories.slug')
            ->leftJoin('posts', 'post_categories.term_id', '=', 'posts.category_id')
            ->select('post_categories.*', DB::raw('COUNT(posts.id) as post_count'))
            ->groupBy('post_categories.term_id', 'post_categories.name', 'post_categories.slug')
            ->orderBy('post_categories.name')
            ->get();
    }

    public function create(array $data)
    {
        return PostCategory::create($data);
    }

    public function editCategory($id)
    {
        $category = PostCategory::findOrFail($id);
        if (!$category) {
            return null;
        }
            
        return $category;
    }

    public function updateCategory(array $data)
    {

        $currentCategory = PostCategory::find($data['term_id']);
    
        // Check if the slug field is empty
        if (empty($data['slug'])) {
            $data['slug'] = $this->textUpperToLower($data['name']);
        } else {
            $data['slug'] = $this->textUpperToLower($data['slug']);
        }
    
        // If the slug has changed, generate a unique slug
        if ($data['slug'] !== $currentCategory->slug) {
            $data['slug'] = $this->generateUniqueSlug($data['slug'], $data['term_id']);
        }
    
        try {
            // Update the category with the new name and slug
            PostCategory::where('term_id', $data['term_id'])->update([
                'name' => $data['name'],
                'slug' => $data['slug']
            ]);

            return [
                'success' => true,
                'message' => 'Category Updated Successfully!',
                'type' => 'success'
            ];
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage(),
                'type' => 'error'
            ];
        }
    }
    
    public function deleteCategory($id)
    {
        try {
            PostCategory::find($id)->delete();
            return [
                'success' => true,
                'message' => 'Category Deleted Successfully!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
                'type' => 'error'
            ];
        }
    }
}
