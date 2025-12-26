<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product; // Import Product model
use App\Mail\LowStockAlert; // Import Mailable
use Illuminate\Support\Facades\Mail;
use App\Models\Setting; // Import Setting model

class CheckLowStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;
    public int $threshold = 5; // Define low stock threshold

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->product->stock_quantity < $this->threshold) {
            $adminEmail = Setting::where('key', 'admin_email')->first()?->value;

            if ($adminEmail) {
                Mail::to($adminEmail)->send(new LowStockAlert($this->product));
            }
        }
    }
}
