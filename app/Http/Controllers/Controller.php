<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function showJson(Product $product): JsonResponse
    {
        return response()->json($product);
    }
}
