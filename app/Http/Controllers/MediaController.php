<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Use the appropriate model for your media

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = Post::all(); // Adjust this based on your media model
        return view('media.library', compact('mediaItems'));
    }

    public function create()
    {
        return view('media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp3,wav,mp4,mov|max:20480',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
        ]);

        $post->addMedia($request->file('media'))->toMediaCollection('default');

        return redirect()->route('media.library')->with('success', 'File uploaded successfully!');
    }
}
