<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductsController extends Controller
{
    private $apiUrl = "https://656ca88ee1e03bfd572e9c16.mockapi.io/products";
    
    public function product()
    {
        $response = Http::get($this->apiUrl);
        
        if ($response->successful()) {
            $products = $response->json();
            return view('products.product', compact('products'));
        } else {
            return back()->withErrors(['message' => 'Không thể lấy dữ liệu từ Mock API']);
        }
    }
}