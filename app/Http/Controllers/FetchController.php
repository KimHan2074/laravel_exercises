<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // Thêm thư viện HTTP client của Laravel

class FetchController extends Controller
{
    // 🟢 Xem danh sách sản phẩm
    public function index()
    {
        // Gọi API lấy danh sách sản phẩm
        $response = Http::get('http://product-api-02.onrender.com/api/v1/products'); // Địa chỉ API
        $products = $response->json()['data']; // Chuyển dữ liệu JSON thành mảng và lấy phần "data"

        return view('pageadmin.admin', compact('products')); // Trả về view với dữ liệu sản phẩm
    }

    public function create(){
        return view('pageadmin.admin-add-frm');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unitPrice' => 'required|numeric',
            'promotionPrice' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Kiểm tra định dạng ảnh
            'unit' => 'required|string|max:255',
            'new' => 'required|boolean',
        ]);

        // Xử lý ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('source/image/product'); // Lưu ảnh vào thư mục storage/app/public/image/product
            // Lấy tên file để lưu vào cơ sở dữ liệu
            $imageName = basename($imagePath);
        } else {
            $imageName = null;  // Nếu không có ảnh, để giá trị null
        }

        // Dữ liệu cần lưu vào API
        $validatedData['image'] = $imageName; // Lưu tên file ảnh vào mảng dữ liệu

        // Gửi dữ liệu đến API để tạo sản phẩm mới
        $response = Http::post('http://product-api-02.onrender.com/api/v1/products', $validatedData);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
        }

        return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi thêm sản phẩm.');
    }

    // 🟢 Hiển thị form chỉnh sửa sản phẩm
    public function edit($product_id)
    {
        // Gọi API để lấy thông tin sản phẩm theo product_id
        $response = Http::get("http://product-api-02.onrender.com/api/v1/products/{$product_id}");
        $product = $response->json();

        return view('pageadmin.admin-edit-frm', compact('product')); // Trả về form chỉnh sửa
    }

   // 🟢 Cập nhật sản phẩm
   public function update(Request $request, $product_id)
   {
       // Xác thực dữ liệu
       $validatedData = $request->validate([
           'name' => 'required|string|max:255',
           'description' => 'nullable|string',
           'unitPrice' => 'required|numeric',
           'promotionPrice' => 'nullable|numeric',
           'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Kiểm tra định dạng ảnh
           'unit' => 'required|string|max:255',
           'new' => 'required|boolean',
       ]);

       // Xử lý ảnh nếu có
       if ($request->hasFile('image')) {
           // Lưu ảnh mới
           $imagePath = $request->file('image')->store('source/image/product'); // Lưu ảnh vào thư mục storage/app/public/image/product
           $imageName = basename($imagePath);
       } else {
           $imageName = $request->input('old_image'); // Nếu không có ảnh mới, giữ ảnh cũ
       }

       // Cập nhật tên ảnh vào dữ liệu
       $validatedData['image'] = $imageName;

       // Gửi dữ liệu đến API để cập nhật sản phẩm
       $response = Http::patch("http://product-api-02.onrender.com/api/v1/products/{$product_id}", $validatedData);

       if ($response->successful()) {
           return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
       }

       return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm.');
   }
   // 🟢 Xóa sản phẩm
    public function destroy($product_id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->delete("https://product-api-02.onrender.com/api/v1/products/{$product_id}");

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa!');
        }

        return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
    }
}
