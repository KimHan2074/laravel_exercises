@extends('master')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form thêm sản phẩm -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="inputName" placeholder="Tên sản phẩm" required>
        <input type="number" name="inputPrice" placeholder="Giá" required>
        <input type="text" name="inputDescription" placeholder="Mô tả">
        
        <input type="number" name="inputPromotionPrice" placeholder="Giá khuyến mãi">
        <!-- <input type="text" name="inputUnit" placeholder="Đơn vị"> -->
        <select name="inputNew">
            <option value="1">Mới</option>
            <option value="0">Cũ</option>
        </select>
        <input type="number" name="inputType" placeholder="Loại sản phẩm">
        <button type="submit">Thêm sản phẩm</button>
    </form>

    <hr>

    <!-- Bảng danh sách sản phẩm -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
               
                
               
                <td>
                    <!-- Form cập nhật -->
                    <form action="{{ route('products.update', $product['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                       
                       
                        <button type="submit">Cập nhật</button>
                    </form>

                    <!-- Form xóa -->
                    <form action="{{ route('products.destroy', $product['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection