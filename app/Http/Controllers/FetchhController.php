<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  

class FetchhController extends Controller
{
    private $apiUrl = 'https://product-api-02.onrender.com/api/v1/products';

    public function index()
    {
        $response = Http::get($this->apiUrl); 
        
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Không thể lấy danh sách sản phẩm.');
        }
        
        $products = $response->json()['data']; 

        return view('pageadmin.admin', compact('products')); 
    }


    public function create()
    {
        return view('pageadmin.admin-add-frm');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unitPrice' => 'required|numeric',
            'promotionPrice' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  
            'unit' => 'required|string|max:255',
            'new' => 'required|boolean',
        ]);

        $dataToSend = $validatedData;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('source/image/product'); 
            $dataToSend['image'] = basename($imagePath);
        }

        $response = Http::post($this->apiUrl, $dataToSend);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
        }

        return back()->withInput()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm: ' . $response->body());
    }

    public function edit($product_id)
    {
        $response = Http::get("{$this->apiUrl}/{$product_id}");
        
        if (!$response->successful()) {
            return redirect()->route('products.index')->with('error', 'Không tìm thấy sản phẩm.');
        }
        
        $product = $response->json()['data'];

        dd($product); 

        return view('pageadmin.admin-edit-frm', compact('product'));
    }


    public function update(Request $request, $product_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unitPrice' => 'required|numeric',
            'promotionPrice' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'unit' => 'required|string|max:255',
            'new' => 'required|boolean',
        ]);

        $dataToSend = $validatedData;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('source/image/product');
            $dataToSend['image'] = basename($imagePath);
        } elseif ($request->has('old_image')) {
            $dataToSend['image'] = $request->input('old_image');
        }

        $response = Http::patch("{$this->apiUrl}/{$product_id}", $dataToSend);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
        }

        return back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $response->body());
    }

    public function destroy($id)
    {
        dd($id); // Kiểm tra ID nhận được có đúng không?

        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã bị xóa!');
        }

        return redirect()->back()->with('error', 'Không thể xóa sản phẩm: ' . $response->body());
    }
}
