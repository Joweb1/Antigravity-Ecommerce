<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product; // Import the Product model

class FeaturedProducts extends Component
{
    public $products;

    public function mount()
    {
        // Fetch a limited number of products, e.g., 3 random products or top 3 by creation date
        $this->products = Product::inRandomOrder()->limit(3)->get();
    }

    public function render()
    {
        return view('livewire.featured-products');
    }
}