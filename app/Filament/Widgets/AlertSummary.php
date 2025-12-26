<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class AlertSummary extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $lowStockThreshold = 10;

        $productsBelowThreshold = Product::where('stock_quantity', '<=', $lowStockThreshold)->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();
        $recentlyLowStock = Product::where('stock_quantity', '<=', $lowStockThreshold)
            ->where('updated_at', '>=', Carbon::now()->subDay())
            ->count();

        return [
            Stat::make('Products Below Threshold', number_format($productsBelowThreshold)),
            Stat::make('Out of Stock Products', number_format($outOfStockProducts)),
            Stat::make('Recently Low Stock', number_format($recentlyLowStock)),
        ];
    }
}
