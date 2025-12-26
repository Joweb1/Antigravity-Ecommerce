<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function showJson(Product $product): JsonResponse
    {
        return response()->json($product);
    }
}
