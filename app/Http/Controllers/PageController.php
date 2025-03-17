<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Slide;
use App\Models\Product;
use App\Models\TypeProduct;
use App\Models\Comment;
use App\Models\BillDetail;

class PageController 
{
    public function getIndex()
    {
        $slide = Slide::all();
        $newproducts = Product::where('new', 1)
                       ->paginate(4);

        // $topProducts1 = Product::where('id_type', 1)
        //            ->limit(4)
        //            ->get();
        // $topProducts2 = Product::where('id_type', 7)
        //            ->limit(4)
        //            ->get();

        $promotion_products = Product::where('promotion_price', '<>', 0)
                              ->paginate(8);

        return view('page.trangchu', compact('slide', 'newproducts', 'promotion_products'));
    }

    public function getLoaiSp($type)									
    {									
        $sp_theoloai = Product::where('id_type', $type)
                       ->get();		

        $type_product = TypeProduct::all();		

        $sp_khac = Product::where('id_type', '<>', $type)
                   ->paginate(3);									
                                            
        return view('page.typeProduct', compact('sp_theoloai', 'type_product', 'sp_khac'));									
    }	
    
    public function getDetail(Request $request)
    {
        $sanpham = Product::where('id', $request->id)->first();

        $splienquan = Product::where('id_type', $sanpham->id_type)
                            ->where('id', '!=', $sanpham->id)
                            ->paginate(3);

        $newproducts = Product::where('new', 1)
                            ->inRandomOrder() 
                            ->paginate(4);

        $bestseller = Product::where('bestseller', 1)
                        ->inRandomOrder() 
                        ->paginate(4);
      
        $comments = Comment::where('id_product', $request->id)->get();

        return view('page.detailProduct', compact('sanpham', 'splienquan', 'comments', 'newproducts', 'bestseller'));
    }

    public function showContact()									
    {									   
        return view('page.contact');									
    }	

    public function showAboutUs()									
    {									   
        return view('page.aboutus');									
    }	

    public function getIndexAdmin()
    {
        $products = Product::all();
        return view('pageadmin.admin')->with([
            'products' => $products, 
            'sumSold' => count(BillDetail::all())
        ]);
    }

    public function showAdminAdd()									
    {									   
        return view('pageadmin.admin-add-frm');									
    }	

    public function postAdminAdd(ProductRequest $request) 
    {
        $product = new Product();
        $file_name = null;
    
        // Kiểm tra và xử lý file ảnh
        if ($request->hasFile('inputImage')) {
            $file = $request->file('inputImage');
            $file_name = $file->getClientOriginalName();
            $file->move('source/image/product', $file_name);
        }
    
        // Gán dữ liệu vào đối tượng Product
        $product->name = $request->inputName;
        $product->image = $file_name;
        $product->description = $request->inputDescription;
        $product->unit_price = $request->inputPrice;
        $product->promotion_price = $request->inputPromotionPrice;
        $product->unit = $request->inputUnit;
        $product->new = $request->inputNew;
        $product->id_type = $request->inputType;
    
        $product->save();
    
        return $this->getIndexAdmin();
    }

    public function getAdminEdit($id)										
    {										
        $product = Product::find($id);										
        return view('pageadmin.admin-edit-frm')->with('product', $product);										
    }		
    
    public function postAdminEdit(Request $request)
    {
        $id = $request->editId;
        $product = Product::find($id);

        if ($request->hasFile('editImage')) {
            $file = $request->file('editImage');
            $fileName = $file->getClientOriginalName('editImage');
            $file->move('source/image/product/', $fileName);
            $product->image = $fileName;
        }

        $product->name = $request->editName;
        $product->description = $request->editDescription;
        $product->unit_price = $request->editPrice;
        $product->promotion_price = $request->editPromotionPrice;
        $product->unit = $request->editUnit;
        $product->new = $request->editNew;
        $product->id_type = $request->editType;

        $product->save();

        return $this->getIndexAdmin();
    }

    public function postAdminDelete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $this->getIndexAdmin();
    }

}
