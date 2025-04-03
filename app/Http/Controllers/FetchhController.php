<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 



class FetchhController extends Controller
{
    private $apiUrl = 'https://product-api-02.onrender.com/api/v1/products';

    public function index()
    {
        $response = Http::get("$this->apiUrl/?page=1");
        $response2 = Http::get("$this->apiUrl/?page=2");
        $response3 = Http::get("$this->apiUrl/?page=3");
        
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Không thể lấy danh sách sản phẩm.');
        }
        
        $products = $response->json()['data'];
        $products = array_merge($products, $response2->json()['data']);
        $products = array_merge($products, $response3->json()['data']);

        return view('pageadmin.admin', compact('products')); 
    }


    public function create()
    {
        return view('pageadmin.admin-add-frm');
    }

    public function store(Request $request)
{
    // Validate dữ liệu đầu vào
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'unitPrice' => 'required|numeric',
        'promotionPrice' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  
        'unit' => 'required|string|max:255',
        'new' => 'required|boolean',
    ]);

    // Xử lý ảnh (nếu có)
    $imagePath = "";
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('source/image/product');
        $imagePath = basename($imagePath); // Lưu tên file để gửi API
    }

    // Định dạng dữ liệu gửi đi
    $formattedData = [
        "name" => $validatedData['name'],
        "description" => $validatedData['description'] ?? null,
        "unitPrice" => (float) $validatedData['unitPrice'],
        "promotionPrice" => (float) ($validatedData['promotionPrice'] ?? 0), 
        "image" => $imagePath, 
        "unit" => $validatedData['unit'] ?? "cái",
        "new" => (boolean) $validatedData['new'] ?? 0
    ];

    // Gửi dữ liệu đến API
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post($this->apiUrl, $formattedData);

    // Chuyển phản hồi thành JSON
    $responseData = $response->json();

    // Chấp nhận mọi mã 2xx là thành công
    if ($response->successful()) {
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    return back()->withErrors([
        'message' => 'Lỗi khi tạo sản phẩm! Mã lỗi: ' . $response->status(),
        'response' => $responseData
    ]);
}

public function edit($product_id)
{
    $response = Http::get("{$this->apiUrl}/{$product_id}");
    
    if (!$response->successful()) {
        return redirect()->route('products.index')->with('error', 'Không tìm thấy sản phẩm.');
    }
    
    $product = $response->json()['data'];


    return view('pageadmin.admin-edit-frm', compact('product'));
}

public function update(Request $request, $id)
{
    // Validate dữ liệu
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'unitPrice' => 'required|numeric',
        'promotionPrice' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'unit' => 'required|string|max:255',
        'new' => 'required|boolean',
    ]);

    // Xử lý ảnh
    $imagePath = "";
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('source/image/product');
        $imagePath = basename($imagePath); // Lấy tên file
    } elseif ($request->has('old_image')) {
        $imagePath = $request->input('old_image'); // Giữ ảnh cũ nếu không có ảnh mới
    }

    //  Định dạng dữ liệu gửi đi
    $formattedData = [
        "name" => $validatedData['name'],
        "description" => $validatedData['description'] ?? "",
        "unitPrice" => (float) $validatedData['unitPrice'],
        "promotionPrice" => (float) ($validatedData['promotionPrice'] ?? 0), 
        "image" => $imagePath, 
        "unit" => $validatedData['unit'] ?? "cái",
        "new" => (boolean) $validatedData['new'] ?? 0
    ];

    // Gửi request cập nhật dữ liệu đến API
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->put("{$this->apiUrl}/$id", $formattedData);

    // Kiểm tra phản hồi từ API
    if ($response->status() == 200) {
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
        // dd($formattedData);
    }

    // Trả về lỗi nếu cập nhật thất bại
    return back()->withErrors([
        'message' => 'Lỗi khi cập nhật sản phẩm! Mã lỗi: ' . $response->status(),
        'response' => $response->json()
    ]);
}

    public function destroy($product_id)
    {

        $response = Http::delete("{$this->apiUrl}/{$product_id}");

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã bị xóa!');
        }

        return redirect()->back()->with('error', 'Không thể xóa sản phẩm: ' . $response->body());
    }
}
