<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = MediaItem::all();
        return view('backend.media.library', compact('mediaItems'));
    }

    public function mediaCreate()
    {
        return view('backend.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $path = $request->file('media')->store('media');
        $mediaItem = new MediaItem();
        $mediaItem->name = $request->file('media')->getClientOriginalName();
        $mediaItem->path = $path;
        $mediaItem->save();

        return redirect()->route('media.index')->with('success', 'Media uploaded successfully.');
    }

    public function show($id)
    {
        $mediaItem = MediaItem::findOrFail($id);
        return view('media.show', compact('mediaItem'));
    }

    public function destroy($id)
    {
        $mediaItem = MediaItem::findOrFail($id);
        Storage::delete($mediaItem->path);
        $mediaItem->delete();
        return redirect()->route('media.index')->with('success', 'Media deleted successfully.');
    }
}
