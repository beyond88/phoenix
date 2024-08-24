<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Common\MediaUploadController;

class MediaController extends Controller
{
    public function index()
    {
        return view('backend.media.media');
    }

    public function addNew()
    {
        return view('backend.media.add-new');
    }

    /**
     * Handle the upload of a new media item.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadNewMedia(Request $request)
    {
        if ($request->hasFile('file')) {
            $mediaUploader = app()->make(MediaUploadController::class);
            $mediaResponse = $mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
        }

        return session()->flash('success', 'Media uploaded successfully!');

    }
}
