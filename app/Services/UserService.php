<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Log;

class UserService extends Controller
{

    public function usernameExists($userName)
    {
        $cacheKey = 'username_exists_' . strtolower($userName);
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $exists = User::where('user_login', $userName)->exists();
        Cache::put($cacheKey, $exists, 300);

        return $exists;
    }

    public function emailExists($email)
    {
        $cacheKey = 'email_exists_' . strtolower($email);
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
    
        $exists = User::where('user_email', $email)->exists();
        Cache::put($cacheKey, $exists, 300);
    
        return $exists;
    }

    public function create( array $data )
    {

        DB::beginTransaction();
        try {
            $user = User::create($data);

            DB::commit();
            return $user; 

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user', [
                'error' => $e->getMessage(),
                'data' => $data,
                'stack_trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}