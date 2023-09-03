<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Component;

class LoginRegisterPage extends Component
{
    public bool $showRegisterForm = false;

    public function render(): View
    {
        return view('livewire.pages.login-register-page');
    }

    public function showRegister(): void
    {
        $this->showRegisterForm = true;
    }

    public function showLogin(): void
    {
        $this->showRegisterForm = false;
    }
}
