<?php

namespace App\Http\Controllers\Backend;

use App\Services\MediaUploader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * The media uploader service instance.
     *
     * @var MediaUploader
     */
    protected $mediaUploader;

    /**
     * Create a new controller instance.
     *
     * @param  MediaUploader  $mediaUploader
     * @return void
     */
    public function __construct(MediaUploader $mediaUploader)
    {
        $this->mediaUploader = $mediaUploader;
    }

    /**
     * Display the media index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.media.media');
    }

    /**
     * Display the add new media page.
     *
     * @return \Illuminate\View\View
     */
    public function addNew()
    {
        return view('backend.media.add-new');
    }

    /**
     * Handle the upload of a new media item.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadNewMedia(Request $request)
    {
        if ($request->hasFile('file')) {
            $mediaResponse = $this->mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
        }

        return session()->flash('success', 'Media uploaded successfully!');
    }

    public function downloadMedia($mediaId) {
        return $this->mediaUploader->downloadMedia($mediaId);
    }
}