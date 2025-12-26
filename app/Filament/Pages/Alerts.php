<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class Alerts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static string $view = 'filament.pages.alerts';

    public $lowStockProducts;
    public $dailySales;

    public function mount()
    {
        $this->lowStockProducts = Product::where('stock_quantity', '<', 5)->get();
        $this->dailySales = Order::whereDate('created_at', Carbon::today())
                                 ->where('status', 'completed')
                                 ->sum('total');
    }
}