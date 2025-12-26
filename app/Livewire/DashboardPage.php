<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DashboardPage extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Auth::user()
            ->orders()
            ->with('orderItems.product') // Eager load relationships
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard-page');
    }
}
