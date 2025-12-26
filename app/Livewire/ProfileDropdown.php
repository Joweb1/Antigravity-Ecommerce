<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class ProfileDropdown extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.profile-dropdown');
    }
}
