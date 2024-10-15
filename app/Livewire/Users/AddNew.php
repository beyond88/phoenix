<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Services\UserService;
use App\Services\MessageService;

class AddNew extends Component
{

    public $userLogin;
    public $userPass;
    public $userEmail;
    public $firstName;
    public $lastName;
    public $userURL;
    public $displayName;

    private $userService;
    private $messageService;

    public function boot(UserService $userService, MessageService $messageService): void
    {
        $this->userService = $userService;
        $this->messageService = $messageService;
    }

    public function registerNewUser()
    {
        if ( '' === $this->userLogin ) {
            $this->messageService->message('error', '<strong>Error:</strong> Please enter a username.');
            return;
        } else if( $this->userService->usernameExists( $this->userLogin ) ) {
            $this->messageService->message('error', '<strong>Error:</strong> This username is already registered. Please choose another one.');
            return;
        }

        \Log::error('Clicked on the button==>' .$this->userLogin);
        // $this->userService->create($data);
    }

    public function render()
    {
        return view('livewire.users.add-new');
    }
}
