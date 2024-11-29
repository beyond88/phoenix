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
        try {

            \Log::info('User Pass:', ['password' => $this->userPass]);

            if (empty($this->userLogin)) {
                throw new \Exception('Please enter a username.');
            } elseif ($this->userService->usernameExists($this->userLogin)) {
                throw new \Exception('This username is already registered. Please choose another one.');
            }

            if (empty($this->userEmail)) {
                throw new \Exception('Please type your email address.');
            } elseif (!is_email($this->userEmail)) {
                throw new \Exception('The email address is not correct.');
            } elseif ($this->userService->emailExists($this->userEmail)) {
                throw new \Exception('This email address is already registered.');
            } elseif (empty($this->userPass)) {
                throw new \Exception('Please enter a password.');
            }

            $data = [
                'user_login' => $this->userLogin,
                'user_pass' => $this->userPass,
                'user_email' => $this->userEmail,
                'user_url' => $this->userURL,
                'display_name' => $this->firstName . " " . $this->lastName,
            ];

            $this->userService->create($data);
            $this->messageService->message('success', 'The user has been created successfully!');
            $this->resetFormFields();

        } catch (\Exception $e) {
            $this->messageService->message('error', $e->getMessage());
            if ($e->getMessage() === 'The email address is not correct.') {
                $this->userEmail = '';
            }
        }
    }

    private function resetFormFields()
    {
        $this->userLogin = '';
        $this->userPass = '';
        $this->userEmail = '';
        $this->userURL = '';
        $this->firstName = '';
        $this->lastName = '';
    }

    public function render()
    {
        return view('livewire.users.add-new');
    }
}
