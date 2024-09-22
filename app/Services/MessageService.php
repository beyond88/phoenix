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

    /**
     * Flash success and error messages based on the deletion result.
     *
     * @param int $successCount
     * @param int $failCount
     * @return void
     */
    public function flashDeletionMessages($successCount, $failCount)
    {
        if ($successCount > 0) {
            $this->message('success', "$successCount data have been deleted successfully.");
        }
        if ($failCount > 0) {
            $this->message('error', "Failed to delete $failCount data.");
        }
    }

    /**
     * Check if the action was successful.
     *
     * @param array $result
     * @return bool
     */
    public function isActionSuccessful($result)
    {
        return isset($result['success']) && $result['success'];
    }

    /**
     * Flash a message to the session based on the type provided.
     *
     *
     * @param string $type The type of message ('success', 'error', or other types).
     * @param string $message The content of the message to be flashed.
     * @return void
     */
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