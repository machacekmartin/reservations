<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class LoginRegisterPage extends Component
{
    public $showRegisterForm = false;

    public function render()
    {
        return view('livewire.pages.login-register-page');
    }

    public function showRegister()
    {
        $this->showRegisterForm = true;
    }

    public function showLogin()
    {
        $this->showRegisterForm = false;
    }
}
