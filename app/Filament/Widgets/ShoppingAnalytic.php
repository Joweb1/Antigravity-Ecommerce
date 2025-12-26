<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ShoppingAnalytic extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $today = Carbon::today();

        $todaysSales = Order::whereDate('created_at', $today)->sum('total');
        $newCustomers = User::whereDate('created_at', $today)->count();
        $totalOrdersToday = Order::whereDate('created_at', $today)->count();

        return [
            Stat::make('Today\'s Sales', '$' . number_format($todaysSales, 2)),
            Stat::make('New Customers', number_format($newCustomers)),
            Stat::make('Total Orders Today', number_format($totalOrdersToday)),
        ];
    }
}
