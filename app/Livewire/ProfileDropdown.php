<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read User|null $user
 */
class ProfileDropdown extends Component
{
    public ?string $avatarUrl;

    public function mount(): void
    {
        $this->avatarUrl = $this->user ? Filament::getUserAvatarUrl($this->user) : null;
    }

    #[Computed()]
    public function user(): ?User
    {
        return auth()->user();
    }
}
