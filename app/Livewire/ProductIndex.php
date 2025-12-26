<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product; // Import the Product model
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class ProductIndex extends Component
{
    use WithPagination;

    public $layout = 'grid';

    public function mount()
    {
        $this->layout = session('layout', 'grid');
    }

    public function toggleLayout()
    {
        $this->layout = $this->layout === 'grid' ? 'list' : 'grid';
        session(['layout' => $this->layout]);
    }
        
    public function addToCart($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($productId);
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItem = $cart->cartItems()->where('product_id', $productId)->first();

        $quantityInCart = $cartItem ? $cartItem->quantity : 0;

        if ($product->stock_quantity > $quantityInCart) {
            if ($cartItem) {
                $cartItem->quantity++;
                $cartItem->save();
            } else {
                $cart->cartItems()->create([
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
            // Notify the cart counter to update
            $this->dispatch('cartUpdated');
            // Optionally, add a success message
            // session()->flash('message', 'Item added to cart!');
        } else {
            // Flash a message to the session
            session()->flash('error', 'Not enough stock to add to cart.');
        }
    }

    public function render()
    {
        return view('livewire.product-index', [
            'products' => Product::paginate(10), // Fetch products with pagination
        ]);
    }
}
