<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // Import Order model
use App\Mail\DailySalesReport; // Import Mailable
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon; // For date manipulation
use App\Models\Setting; // Import Setting model

class SendDailySales implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::today();

        $dailySales = Order::whereDate('created_at', $today)
                           ->where('status', 'completed') // Only count completed orders
                           ->sum('total');
        
        $adminEmail = Setting::where('key', 'admin_email')->first()?->value;

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new DailySalesReport($dailySales));
        }
    }
}
