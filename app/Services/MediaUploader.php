<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        try {
            $media = Media::findOrFail($id);
            $mediaName = $media->media_name;
            $filePath = "media/$mediaName";

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $message = Storage::disk('public')->exists($filePath) ? 
                    'Media deleted successfully!' : 
                    'Media record deleted, but the file was not found in storage.';
            $type = 'success';

            $media->delete();

            return [
                'success' => true,
                'message' => $message,
                'type' => $type
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage(),
                'type' => 'error'
            ];
        }
    }

    public function downloadMedia($mediaId)
    {
        try {
            $media = Media::findOrFail($mediaId);
            $filePath = "media/{$media->media_name}";
    
            // Verify if the file exists
            if (Storage::disk('public')->exists($filePath)) {
                // Return file for download
                return response()->download(storage_path("app/public/{$filePath}"));
            } else {
                // Handle the case where file does not exist
                return response()->json(['error' => 'File not found.'], 404);
            }
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Download failed: ' . $e->getMessage()], 500);
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

    public function getFormattedDate($date)
    {

        if ($date === '0000-00-00 00:00:00' || !$date) {
            return __('Unpublished');
        }

        $date = Carbon::parse($date);
        $now = Carbon::now();
        $timeDiff = $now->diffInSeconds($date);
        
        if ($timeDiff > 0 && $timeDiff < 86400) {
            return sprintf(__(' %s ago'), $this->humanTimeDiff($now));
        } else {
            return $date->format('Y/m/d');
        }
    }

    public function humanTimeDiff($from, $to = null)
    {
        // Set the default value of $to to the current time if it's not provided
        if (is_null($to)) {
            $to = Carbon::now();
        } else {
            $to = Carbon::parse($to);
        }
        
        // Parse the $from value into a Carbon instance
        $from = Carbon::parse($from);
        
        // Calculate the difference between the two dates
        $diffInSeconds = $to->diffInSeconds($from);
        
        // Determine the appropriate unit of time and format the output
        if ($diffInSeconds < 60) {
            $secs = max($diffInSeconds, 1);
            return sprintf(__('%s second|%s seconds'), $secs, $secs);
        } elseif ($diffInSeconds < 3600) {
            $mins = max(round($diffInSeconds / 60), 1);
            return sprintf(__('%s min|%s mins'), $mins, $mins);
        } elseif ($diffInSeconds < 86400) {
            $hours = max(round($diffInSeconds / 3600), 1);
            return sprintf(__('%s hour|%s hours'), $hours, $hours);
        } elseif ($diffInSeconds < 604800) {
            $days = max(round($diffInSeconds / 86400), 1);
            return sprintf(__('%s day|%s days'), $days, $days);
        } elseif ($diffInSeconds < 2592000) {
            $weeks = max(round($diffInSeconds / 604800), 1);
            return sprintf(__('%s week|%s weeks'), $weeks, $weeks);
        } elseif ($diffInSeconds < 31536000) {
            $months = max(round($diffInSeconds / 2592000), 1);
            return sprintf(__('%s month|%s months'), $months, $months);
        } else {
            $years = max(round($diffInSeconds / 31536000), 1);
            return sprintf(__('%s year|%s years'), $years, $years);
        }
    }

}
