<?php

namespace App\Services;

use App\Models\Post;
use App\Models\TermRelationship;
use App\Models\TermTaxonomy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PostService extends Controller
{

    public function formatDate($timestamp = null, $timezone = null)
    {
        try {
            if ($timestamp === null) {
                $date = Carbon::now();
            } else {
                $date = Carbon::parse($timestamp);
            }

            if ($timezone) {
                try {
                    $date->setTimezone($timezone);
                } catch (\Exception $e) {
                    $date->setTimezone('UTC');
                    $timezone = null;
                }
            } else {
                $date->setTimezone(config('app.timezone'));
            }
            return $date->format('M d, h:i A');
        } catch (\Exception $e) {
            return 'Date unavailable';
        }
    }

    public function create(array $data)
    {
        $post = Post::create($data);
        return $post->id;
    }

    public function update(array $data)
    {
        $post = Post::findOrFail($data['id']);
        unset($data['id']);
        $post->update($data);
    
        return $post;
    }    

    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->post_type === 'page') {
                $message = 'Page deleted successfully!';
            } elseif ($post->post_type === 'post') {
                $message = 'Post deleted successfully!';
            }

            if ($post->post_type === 'post') {
                $termTaxonomies = TermRelationship::where('object_id', $id)->get();
            }
            
            $post->delete();
            
            if ($post->post_type === 'post') {
                $this->deleteTermRelationships($id);
                foreach ($termTaxonomies as $termRelationship) {
                    $this->decreementTermTaxonomyCount($termRelationship->term_taxonomy_id);
                }
            }
    
            return [
                'success' => true,
                'message' => $message,
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage(),
                'type' => 'error'
            ];
        }
    }

    public function getAllPosts(array $filters = [])
    {

        $query = Post::query()
            ->leftJoin('media', 'posts.media_id', '=', 'media.id')
            ->select('posts.*', 'media.media_name');

        if (!empty($filters['post_type'])) {
            $query->where('posts.post_type', '=', $filters['post_type']);
        }

        if (!empty($filters['post_type']) && $filters['post_type'] == "post") {
            $query->join('term_relationships', 'posts.id', '=', 'term_relationships.object_id')
                ->join('terms', 'term_relationships.term_taxonomy_id', '=', 'terms.term_id')
                ->addSelect('terms.name as category_name');
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('post_title', 'like', '%' . $search . '%')
                    ->orWhere('post_content', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filters['category_id']) && $filters['category_id'] > 0) {
            $query->where('term_relationships.term_taxonomy_id', '=', $filters['category_id']);
        }

        if (!empty($filters['post_status']) && $filters['post_status'] !== 'all') {
            $query->where('posts.post_status', '=', $filters['post_status']);
        }

        if (!empty($filters['selected_date']) && $filters['selected_date'] !== 'all') {
            $year = substr($filters['selected_date'], 0, 4);
            $month = substr($filters['selected_date'], 4, 2);
            $query->whereYear('posts.created_at', $year)
                ->whereMonth('posts.created_at', $month);
        }

        $publish = Post::where('post_status', 'publish')->where('post_type', $filters['post_type'])->count();
        $draft = Post::where('post_status', 'draft')->where('post_type', $filters['post_type'])->count();

        $orderBy = $filters['orderBy'] ?? 'desc';
        $query->orderBy('created_at', $orderBy);

        $perPage = $filters['perPage'] ?? 20;
        $page = $filters['page'] ?? 1;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'posts' => $paginator->items(),
            'publish' => $publish,
            'draft' => $draft,
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
        ];

    }

    public function getPostById($id)
    {

        if (!is_numeric($id) || $id <= 0) {
            return null;
        }

        $post = Post::leftJoin('media', 'posts.media_id', '=', 'media.id')
                ->leftJoin('term_relationships', 'posts.id', '=', 'term_relationships.object_id')
                ->leftJoin('terms', 'term_relationships.term_taxonomy_id', '=', 'terms.term_id')
                ->select(
                    'posts.*',
                    'media.media_name',
                    'media.id as media_id',
                    'terms.name as category_name',
                    'terms.term_id as category_id'
                )
                ->where('posts.id', $id)
                ->first();

        if (!$post) {
            return null;
        }

        return [
            'id' => $post->id,
            'post_title' => $post->post_title,
            'post_content' => $post->post_content,
            'media_id' => $post->media_id,
            'media_name' => $post->media_name,
            'category_id' => $post->category_id,
            'category_name' => $post->category_name,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'status' => $post->post_status
        ];
    }

    public function loadMonths()
    {
        return Post::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
        ->whereNotNull('post_title')
        ->distinct()
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }

    public function getTermTaxonomy($termId) {
        return TermTaxonomy::select('term_taxonomy_id', 'term_id', 'taxonomy', 'description', 'count')
                ->where('term_id', $termId)
                ->first();
    }

    public function increementTermTaxonomyCount($termTaxonomyId)
    {
        $termTaxonomy = TermTaxonomy::find($termTaxonomyId);
        if ($termTaxonomy) {
            $termTaxonomy->increment('count');
        }
    }

    public function decreementTermTaxonomyCount($termTaxonomyId)
    {
        $termTaxonomy = TermTaxonomy::find($termTaxonomyId);
        if ($termTaxonomy) {
            $termTaxonomy->decrement('count');
        }
    }

    public function addTermRelationships(array $data)
    {
        return TermRelationship::create($data);
    }

    public function updateTermRelationships(array $data) 
    {
        $termRelationships = TermRelationship::findOrFail($data['object_id']);
        $termRelationships->update($data);
        return $termRelationships;
    }

    public function deleteTermRelationships($postId)
    {
        $termRelationships = TermRelationship::where('object_id', $postId)->delete();
        Log::info('term relationships', ['termRelationships' => $termRelationships]);
    }

}
