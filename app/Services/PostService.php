<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostService extends Controller
{

    /**
     * Formats a timestamp into a human-readable date string.
     *
     * @param string $timestamp The timestamp to format (e.g., 'Y-m-d H:i:s').
     * @param string|null $timezone Optional timezone for formatting. Defaults to the application's timezone if null.
     * @return string Formatted date string in 'M d, h:i A' format.
     */
    public function formatDate($timestamp = null, $timezone = null)
    {
        try {
            // If no timestamp is provided, use current time
            if ($timestamp === null) {
                $date = Carbon::now();
            } else {
                // Create a date from the provided timestamp string
                $date = Carbon::parse($timestamp);
            }

            // If a timezone is provided, set it
            if ($timezone) {
                try {
                    $date->setTimezone($timezone);
                } catch (\Exception $e) {
                    // If timezone is invalid, fall back to UTC
                    $date->setTimezone('UTC');
                    $timezone = null;
                }
            } else {
                // If no timezone is provided, use the application's timezone
                $date->setTimezone(config('app.timezone')); // Use local app timezone
            }

            // Format the date as "M d, h:i A"
            return $date->format('M d, h:i A');
        } catch (\Exception $e) {
            // If anything goes wrong, return a fallback string
            return 'Date unavailable';
        }
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return \App\Models\Post
     */
    public function create(array $data)
    {
        return Post::create($data);
    }

    /**
     * Update an existing post.
     *
     * @param \App\Models\Post $post
     * @param array $data
     * @return \App\Models\Post
     */
    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    /**
     * Deletes a post by its ID.
     *
     * This method checks if the provided ID is a valid integer and whether
     * a post with that ID exists before attempting to delete it.
     *
     * @param int $id The ID of the post to delete.
     * @return bool True if the post was deleted, false otherwise.
     */
    public function delete($id)
    {
        try {
            // Check if the post exists
            $post = Post::findOrFail($id);

            // Delete the post
            $post->delete();
    
            return [
                'success' => true,
                'message' => 'Post deleted successfully!',
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

    /**
     * Search posts based on a query.
     *
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(string $query)
    {
        return Post::where('post_title', 'like', '%' . $query . '%')
                   ->orWhere('post_content', 'like', '%' . $query . '%')
                   ->get();
    }

    /**
     * Get all posts with optional search, pagination, and ordering.
     * Also returns total post count and current page number if paginated.
     *
     * @param array $filters Filters like 'perPage', 'page', 'search', and 'orderBy'
     * @return array Contains posts, total post count, and current page number
     */
    public function getAllPosts(array $filters = [])
    {

        $query = Post::query()
        ->leftJoin('media', 'posts.media_id', '=', 'media.id') // Use leftJoin to handle optional media_id
        ->join('post_categories', 'posts.category_id', '=', 'post_categories.term_id') // Regular join for categories
        ->select('posts.*', 'media.media_name', 'post_categories.name as category_name');

        // Apply search filter if present
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('post_title', 'like', '%' . $search . '%')
                ->orWhere('post_content', 'like', '%' . $search . '%');
            });
        }

        // Total publish and draft posts
        $publish = Post::where('post_status', 'publish')->count();
        $draft = Post::where('post_status', 'draft')->count();

        // Apply orderBy filter if present, default to 'desc'
        $orderBy = $filters['orderBy'] ?? 'desc';
        $query->orderBy('created_at', $orderBy);

        // Set perPage value, default to 20 if not provided
        $perPage = $filters['perPage'] ?? 20;

        // Apply pagination, default page is 1 if not provided
        $page = $filters['page'] ?? 1;
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'posts' => $paginator->items(),
            'publish' => $publish,
            'draft' => $draft,
            'total' => $paginator->total(),        // Total number of posts
            'current_page' => $paginator->currentPage(),  // Current page number
            'per_page' => $paginator->perPage(),   // Number of posts per page
        ];
    }

    /**
     * Loads distinct months from the media records.
     *
     * @return void
     */
    public function loadMonths()
    {
        return Post::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
        ->whereNotNull('post_title')
        ->distinct()
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }


}
