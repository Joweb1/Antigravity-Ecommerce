<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Jobs\CheckLowStock;

class CartPage extends Component
{
    public $cart;
    public $totalPrice = 0;

    // The 'cartUpdated' listener keeps the cart page reactive to changes
    // (e.g., if another browser tab adds an item, this component will know).
    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        if (Auth::check()) {
            // Eager load products and their relationships to prevent N+1 query issues
            $this->cart = Auth::user()->cart()->with('cartItems.product')->firstOrCreate([]);
            $this->calculateTotalPrice();
        } else {
            $this->cart = null;
            $this->totalPrice = 0;
        }
    }

    public function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        if ($this->cart && $this->cart->cartItems) {
            foreach ($this->cart->cartItems as $item) {
                $this->totalPrice += $item->quantity * $item->product->price;
            }
        }
    }

    public function increment($itemId)
    {
        $cartItem = $this->cart->cartItems()->find($itemId);
        if ($cartItem && $cartItem->product->stock_quantity > $cartItem->quantity) {
            $cartItem->quantity++;
            $cartItem->save();
            $this->refreshCart();
            $this->dispatch('cartUpdated'); // Notify other components like the cart counter
        } else {
            session()->flash('error', 'Cannot add more. Not enough stock.');
        }
    }

    public function decrement($itemId)
    {
        $cartItem = $this->cart->cartItems()->find($itemId);
        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
            $this->refreshCart();
            $this->dispatch('cartUpdated');
        } elseif ($cartItem && $cartItem->quantity === 1) {
            $this->remove($itemId); // Just remove it if quantity becomes 0
        }
    }

    public function remove($itemId)
    {
        $cartItem = $this->cart->cartItems()->find($itemId);
        if ($cartItem) {
            $cartItem->delete();
            $this->refreshCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function checkout()
    {
        if (!Auth::check() || !$this->cart || $this->cart->cartItems->isEmpty()) {
            return redirect()->route('login');
        }

        DB::transaction(function () {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $this->totalPrice,
                'status' => 'pending', // Or 'completed', 'processing' etc.
            ]);

            foreach ($this->cart->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = $item->product;
                if($product->stock_quantity < $item->quantity) {
                    throw new \Exception('Not enough stock for ' . $product->name);
                }
                $product->stock_quantity -= $item->quantity;
                $product->save();

                CheckLowStock::dispatch($product);
            }

            $this->cart->cartItems()->delete();
        });

        $this->dispatch('cartUpdated');
        session()->flash('message', 'Order placed successfully! You will be redirected shortly.');

        // Redirect to a confirmation page or dashboard after a delay
        return redirect()->route('dashboard');
    }


    public function render()
    {
        return view('livewire.cart-page')
            ->layout('layouts.app');
    }
}
