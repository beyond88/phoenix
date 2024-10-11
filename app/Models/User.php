<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_login',       // Login username
        'user_pass',        // Password (hashed)
        'user_nicename',    // URL-friendly name
        'user_email',       // Email address
        'user_url',         // User's website URL
        'user_registered',  // Registration date
        'user_activation_key',  // Activation key (for password resets, etc.)
        'user_status',      // Status (e.g., for custom status management)
        'display_name',     // Display name (public name)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_pass',         // Password should be hidden
        'remember_token',    // Remember me token
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_registered' => 'datetime', // Cast the registration date as a datetime
        ];
    }

    /**
     * Override the password attribute.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['user_pass'] = bcrypt($password); // Hash the password and store it in user_pass
    }
}
