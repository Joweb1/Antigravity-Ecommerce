<x-filament-panels::page>
    <div class="space-y-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Low Stock Alerts
            </h2>
            <div class="mt-4">
                <x-filament::card>
                    <div class="overflow-hidden shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 sm:rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                            <thead class="bg-gray-50 dark:bg-white/5">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                                        Stock Quantity
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($lowStockProducts as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $product->stock_quantity }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400 text-center">
                                            No low stock products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-filament::card>
            </div>
        </div>
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Daily Sales Reports
            </h2>
            <div class="mt-4">
                <x-filament::card>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Today's Sales
                        </h3>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($dailySales, 2) }}
                        </p>
                    </div>
                </x-filament::card>
            </div>
        </div>
    </div>
</x-filament-panels::page>
