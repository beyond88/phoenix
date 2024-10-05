<?php

namespace App\Services;

use App\Models\Terms;
use App\Models\TermTaxonomy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CategoryService extends Controller
{

    public function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        while (Terms::where('slug', $slug)->exists()) {
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
        return Terms::select('*')
            ->orderBy('terms.term_id')
            ->get();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $term = Terms::create($data);
            $termTaxonomy = TermTaxonomy::create([
                'term_id' => $term->term_id,
                'taxonomy' => 'category',
                'description' => $data['description'] ?? '',
                'parent' => $data['parent'] ?? 0,
                'count' => 0
            ]);

            DB::commit();

            return $term;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating category', [
                'error' => $e->getMessage(),
                'data' => $data,
                'stack_trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function editCategory($id)
    {
        $category = Terms::findOrFail($id);
        if (!$category) {
            return null;
        }
            
        return $category;
    }

    public function updateCategory(array $data)
    {

        $currentCategory = Terms::find($data['term_id']);
    
        if (empty($data['slug'])) {
            $data['slug'] = $this->textUpperToLower($data['name']);
        } else {
            $data['slug'] = $this->textUpperToLower($data['slug']);
        }
    
        if ($data['slug'] !== $currentCategory->slug) {
            $data['slug'] = $this->generateUniqueSlug($data['slug'], $data['term_id']);
        }
    
        try {
            Terms::where('term_id', $data['term_id'])->update([
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
        DB::beginTransaction();

        try {
            $term = Terms::findOrFail($id);
            $deletedTaxonomy = TermTaxonomy::where('term_id', $id)->delete();
            $term->delete();
            DB::commit();

            return [
                'success' => true,
                'message' => 'Category Deleted Successfully!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting category', [
                'term_id' => $id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
                'type' => 'error'
            ];
        }
    }
}
