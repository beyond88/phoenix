<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;

class RoleCapabilityManager extends Controller
{
    private $roles;
    private $userRoles = [];

    private static $defaultRoles = [
        'administrator' => [
            'name' => 'Administrator',
            'position' => 100,
            'capabilities' => [
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'edit_others_posts' => true,
                'create_users' => true,
                'edit_users' => true,
                'delete_users' => true,
                'list_users' => true,
                'manage_options' => true,
            ],
        ],
        'editor' => [
            'name' => 'Editor',
            'position' => 80,
            'capabilities' => [
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'edit_others_posts' => true,
            ],
        ],
        'author' => [
            'name' => 'Author',
            'position' => 60,
            'capabilities' => [
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
            ],
        ],
        'contributor' => [
            'name' => 'Contributor',
            'position' => 40,
            'capabilities' => [
                'read' => true,
                'edit_posts' => true, // Can edit their own posts
            ],
        ],
        'subscriber' => [
            'name' => 'Subscriber',
            'position' => 20,
            'capabilities' => [
                'read' => true,
            ],
        ],
    ];

    public function __construct()
    {
        $this->roles = $this->getRoles();
    }

    private function getRoles()
    {
        return Cache::remember('user_roles', 3600, function () {
            $roles = DB::table('options')->where('option_name', 'user_roles')->first();
            if ($roles) {
                return json_decode($roles->value, true);
            }
            $this->resetRoles();
            return self::$defaultRoles;
        });
    }

    public function resetRoles()
    {
        DB::table('options')->updateOrInsert(
            ['option_name' => 'user_roles'], // Change 'key' to 'option_name'
            ['option_value' => json_encode(self::$defaultRoles)] // Change 'value' to 'option_value'
        );
        Cache::forget('user_roles');
        $this->roles = self::$defaultRoles;
    }

    public function addRole($role, $display_name, $capabilities = [], $position = 0)
    {

        if (!isset($this->roles[$role])) {
            $this->roles[$role] = [
                'name' => $display_name,
                'position' => $position,
                'capabilities' => $capabilities,
            ];

            $this->updateRoles();
            
            Cache::forget('user_roles');
        }
    }

    public function removeRole($role)
    {
        if (isset($this->roles[$role])) {
            unset($this->roles[$role]);
            $this->updateRoles();
        }
    }

    public function addCapability($role, $capability)
    {
        if (isset($this->roles[$role])) {
            $this->roles[$role]['capabilities'][$capability] = true;
            $this->updateRoles();
        }
    }

    public function removeCapability($role, $capability)
    {
        if (isset($this->roles[$role]['capabilities'][$capability])) {
            unset($this->roles[$role]['capabilities'][$capability]);
            $this->updateRoles();
        }
    }

    private function updateRoles()
    {
        DB::table('options')->updateOrInsert(
            ['option_name' => 'user_roles'], // Update to match your database schema
            ['option_value' => json_encode($this->roles)] // Use correct field names
        );
        Cache::forget('user_roles');
    }


    public function userCan($userId, $capability)
    {
        if (!isset($this->userRoles[$userId])) {
            $this->userRoles[$userId] = $this->getUserRoles($userId);
        }

        foreach ($this->userRoles[$userId] as $role) {
            if (isset($this->roles[$role]['capabilities'][$capability]) && 
                $this->roles[$role]['capabilities'][$capability]) {
                return true;
            }
            
            // Check if the user can perform the capability based on hierarchy
            foreach ($this->roles as $r) {
                if ($r['position'] < $this->roles[$role]['position'] && 
                    isset($r['capabilities'][$capability]) && 
                    $r['capabilities'][$capability]) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getUserRoles($userId)
    {
        //return DB::table('user_roles')->where('user_id', $userId)->pluck('role')->toArray() ?: ['subscriber'];
    }

    public function assignUserRole($userId, $role)
    {
        // if (isset($this->roles[$role])) {
        //     DB::table('user_roles')->updateOrInsert(
        //         ['user_id' => $userId],
        //         ['role' => $role]
        //     );
        //     unset($this->userRoles[$userId]); // Clear cache
        // }
    }

    public function removeUserRole($userId)
    {
        // DB::table('user_roles')->where('user_id', $userId)->delete();
        // unset($this->userRoles[$userId]); // Clear cache
    }
}