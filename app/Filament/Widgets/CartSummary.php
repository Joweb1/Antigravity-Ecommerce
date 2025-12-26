<?php

namespace App\Filament\Widgets;

use App\Models\Cart;
use App\Models\CartItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class CartSummary extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalCarts = Cart::count();
        $pendingCarts = Cart::has('cartItems')->count();
        $abandonedCarts = Cart::whereHas('cartItems')
            ->where('updated_at', '<', Carbon::now()->subDays(7))
            ->count();

        return [
            Stat::make('Total Carts', number_format($totalCarts)),
            Stat::make('Pending Carts', number_format($pendingCarts)),
            Stat::make('Abandoned Carts', number_format($abandonedCarts)),
        ];
    }
}
