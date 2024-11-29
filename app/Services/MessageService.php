<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MessageService extends Controller
{

    public function flashDeletionMessages($successCount, $failCount)
    {
        if ($successCount > 0) {
            $this->message('success', "$successCount data have been deleted successfully.");
        }
        if ($failCount > 0) {
            $this->message('error', "Failed to delete $failCount data.");
        }
    }

    public function isActionSuccessful($result)
    {
        return isset($result['success']) && $result['success'];
    }

    public function message($type, $message) {
        switch ($type) {
            case 'success':
                session()->flash('success', $message);
                break;
    
            case 'error':
                session()->flash('error', $message);
                break;
    
            default:
                session()->flash('message', $message);
                break;
        }
    }    

}