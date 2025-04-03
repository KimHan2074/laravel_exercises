@extends('master')

@section('content')

<link rel="stylesheet" href="/assets/css/admin.css">

<div class="container mt-4">
    <!-- Thông tin tổng quan -->
    <div class="row g-3 mb-4">
        <!-- Thẻ Số sản phẩm
        <div class="col-md-4">
            <div class="stat-card bg-gradient-primary">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-content">
                    <h3>Số sản phẩm</h3>
                    <div class="stat-value" id="totalProducts">0</div>
                </div>
            </div>
        </div> -->
    
        <!-- Thẻ Đã bán -->
        <div class="col-md-8">
            <div class="stat-card bg-gradient-success">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>Đã bán</h3>
                    <div class="stat-details">
                        <div class="stat-item">
                            <span class="stat-label">Tổng:</span>
                            <span class="stat-number" id="totalSold">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Hôm nay:</span>
                            <span class="stat-number" id="todaySold">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tháng này:</span>
                            <span class="stat-number" id="monthSold">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Năm nay:</span>
                            <span class="stat-number" id="yearSold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tiêu đề + Xuất PDF -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2 class="fw-bold mb-0">Danh sách sản phẩm</h2>
        <div>
            <a href="#" class="export-pdf-btn">
                <i class="fa fa-file-pdf"></i> Xuất ra PDF
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary ms-2">
                <i class="fa fa-plus"></i> Thêm sản phẩm
            </a>
        </div>
    </div>

    <!-- Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <!-- Bảng sản phẩm -->
    <div class="mt-3">
        <table class="product-table" id="table_admin_product">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá gốc</th>
                    <th>Giá KM</th>
                    <th>Đơn vị</th>
                    <th>Mới</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
            @foreach($products as $product)
            <tr>
                <th scope="row">{{ $product['product_id'] }}</th>
                <td>
                    @if($product['image'])
                        <img src="{{ asset('source/image/product/' . $product['image']) }}" alt="Product Image" style="height: 100px;">
                    @else
                        <span>No image</span>
                    @endif
                </td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['description'] ?? 'No description' }}</td>
                <td>{{ number_format($product['unitPrice'], 0, ',', '.') }} VND</td>
                <td>{{ number_format($product['promotionPrice'], 0, ',', '.') }} VND</td>
                <td>{{ $product['unit'] }}</td>
                <td>{{ $product['new'] }}</td>
                <td>
                    <a href="{{ route('products.edit', $product['product_id']) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product['product_id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Khởi tạo DataTable
    const table = $('#table_admin_product').DataTable({
        "language": {
            "lengthMenu": "Hiển thị _MENU_ sản phẩm",
            "zeroRecords": "Không tìm thấy sản phẩm",
            "info": "Đang hiển thị _START_ - _END_ của _TOTAL_ sản phẩm",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(lọc từ _MAX_ sản phẩm)",
            "search": "Tìm kiếm:",
            "paginate": {
                "next": "Trang tiếp »",
                "previous": "« Trang trước"
            }
        },
        "responsive": true
    });

    // Fetch dữ liệu sản phẩm
    function fetchProducts() {
        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                // Xóa dữ liệu cũ
                table.clear().draw();
                
                // Thêm dữ liệu mới
                data.forEach(product => {
                    table.row.add([
                        product.product_id,
                        product.image ? 
                            `<img src="/source/image/product/${product.image}" alt="image" class="product-image">` : 
                            '<div class="no-image">No image</div>',
                        product.name,
                        product.description ? product.description.substring(0, 50) + (product.description.length > 50 ? '...' : '') : '',
                        product.unit_price ? formatPrice(product.unit_price) + ' đ' : '0 đ',
                        product.promotion_price ? formatPrice(product.promotion_price) + ' đ' : '0 đ',
                        product.unit || '',
                        product.new ? '<span class="new-badge">Mới</span>' : '<span class="old-badge">Cũ</span>',
                        `<a href="/products/${product.product_id}/edit" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Sửa
                        </a>
                        <form action="/products/${product.product_id}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="fa fa-trash"></i> Xóa
                            </button>
                        </form>`
                    ]).draw(false);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Fetch thống kê
    function fetchStatistics() {
        fetch('/api/statistics')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalProducts').textContent = data.totalProducts || 0;
                document.getElementById('totalSold').textContent = data.totalSold || 0;
                document.getElementById('todaySold').textContent = data.todaySold || 0;
                document.getElementById('monthSold').textContent = data.monthSold || 0;
                document.getElementById('yearSold').textContent = data.yearSold || 0;
            })
            .catch(error => console.error('Error:', error));
    }

    // Định dạng giá
    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Gọi các hàm fetch khi trang được tải
    fetchProducts();
    fetchStatistics();
});
</script>

@endsection

