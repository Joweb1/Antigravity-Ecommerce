<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartCounter extends Component
{
    public $cartItemCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartItemCount'];

    public function mount()
    {
        $this->updateCartItemCount();
    }

    public function updateCartItemCount()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart;
            $this->cartItemCount = $cart ? $cart->cartItems()->sum('quantity') : 0; // Sum of quantities
        } else {
            $this->cartItemCount = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
