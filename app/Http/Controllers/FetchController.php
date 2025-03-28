<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FetchController extends Controller
{
    public $apiUrl = 'https://vuive-01.onrender.com/api/products'; // API test

    // 🟢 Lấy danh sách sản phẩm từ API
    public function index()
    {
        $response = Http::get($this->apiUrl);
        $products = $response->json();

        return view('pageadmin.admin', compact('products'));
    }

    // 🟢 Thêm sản phẩm mới
    public function store(Request $request)
    {
        // 🔍 Debug xem dữ liệu form có nhận được không
        // dd($request->all());

        // Gửi dữ liệu JSON đúng format
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($this->apiUrl, [
      
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'category' => $request->input('category')
        ]);

        // 🔍 Debug API phản hồi gì
        if ($response->failed()) {
            return redirect()->back()->with('error', 'Không thể thêm sản phẩm: ' . $response->body());
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    // 🟢 Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $response = Http::put("$this->apiUrl/$id", [
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'category' => $request->input('category')
        ]);

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Không thể cập nhật sản phẩm: ' . $response->body());
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    // 🟢 Xóa sản phẩm
    public function destroy($id)
    {
        $response = Http::delete("$this->apiUrl/$id");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Không thể xóa sản phẩm: ' . $response->body());
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã bị xóa!');
    }
}