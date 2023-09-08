<?php

namespace App\View\Components\Pages;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class ReservationsPage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        /** @var User $user */
        $user = auth()->user();

        $reservations = $user->reservations()->orderBy('start_at', 'desc')->get();

        return view('components.pages.reservations-page', [
            'reservations' => $reservations,
        ]);
    }
}
