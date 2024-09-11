<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploader extends Controller
{

    /**
     * Upload media file.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMedia(Request $request)
    {
       
        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $newFileName = $fileName.'_'.Str::random(10).'.'.$extension;
            while ($this->checkForDuplicate($fileName, $extension, $newFileName)) {
                $newFileName = $fileName.'_'.Str::random(10).'.'.$extension;
            }

            $file->storeAs('public/media', $newFileName);

            $mediaId = Media::create([
                'media_name' => $newFileName,
            ])->id;

            return response()->json(['media_id' => $mediaId]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Upload failed'], 500);
        }
    }

    /**
     * Check for duplicate filename in media table and storage.
     *
     * @param  string  $fileName
     * @param  string  $extension
     * @param  string  $newFileName  (optional)
     * @return bool
     */
    private function checkForDuplicate($fileName, $extension, $newFileName = null)
    {
        $existingMedia = Media::where('media_name', $fileName.'.'.$extension)->first();

        if ($existingMedia) {
            return true;
        }

        if ($newFileName) {
            return Storage::disk('public')->exists("media/$newFileName");
        }

        return Storage::disk('public')->exists("media/$fileName.$extension");
    }

    /**
     * Delete media file.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMedia($id)
    {
        // try {
        //     $media = Media::findOrFail($id);
        //     $mediaName = $media->media_name;
        //     $filePath = "media/$mediaName";

        //     if (Storage::disk('public')->exists($filePath)) {
        //         Storage::disk('public')->delete($filePath);
        //     }

        //     $media->delete();

        //     $message = Storage::disk('public')->exists($filePath) ? 'Media deleted successfully!' : 'Media record deleted successfully, but the file was not found in storage.';
        //     $type = 'success';

        //     return redirect()->route('media.media')->with('message', $message)->with('type', $type);
        // } catch (\Exception $e) {
        //     return redirect()->route('media.media')->with('message', 'Deletion failed: '.$e->getMessage())->with('type', 'error');
        // }

        try {
            $media = Media::findOrFail($id);
            $mediaName = $media->media_name;
            $filePath = "media/$mediaName";
    
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
    
            $media->delete();
    
            $message = Storage::disk('public')->exists($filePath) ? 
                       'Media deleted successfully!' : 
                       'Media record deleted successfully, but the file was not found in storage.';
            $type = 'success';
    
            return response()->json([
                'message' => $message,
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Deletion failed: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function getMediaPlaceholderIcon($mediaFileName)
    {
        // Define supported file types and their corresponding icons
        $mediaTypes = [
            'pdf' => 'document.svg',
            'doc' => 'document.svg',
            'docx' => 'document.svg',
            'ppt' => 'document.svg',
            'pptx' => 'document.svg',
            'ods' => 'document.svg',
            'xls' => 'document.svg',
            'xlsx' => 'document.svg',
            'psd' => 'document.svg',
            'xml' => 'code.svg',
            'mp3' => 'audio.svg',
            'm4a' => 'audio.svg',
            'ogg' => 'audio.svg',
            'wav' => 'audio.svg',
            'mp4' => 'video.svg',
            'm4v' => 'video.svg',
            'mov' => 'video.svg',
            'wmv' => 'video.svg',
            'avi' => 'video.svg',
            'mpg' => 'video.svg',
            'mpeg' => 'video.svg',
            'ogv' => 'video.svg',
            '3gp' => 'video.svg',
            '3g2' => 'video.svg',
            'zip' => 'archive.svg',
            'rar' => 'archive.svg',
            '7z' => 'archive.svg',
        ];

        // Get the file extension
        $extension = strtolower(pathinfo($mediaFileName, PATHINFO_EXTENSION));

        // If the media type is an image (jpg, jpeg, png, gif), return the original media path
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($extension, $imageTypes)) {
            return $mediaFileName;
        }

        // Otherwise, return the corresponding placeholder icon
        return asset('img/placeholders/' . ($mediaTypes[$extension] ?? 'default.svg'));
    }

}
