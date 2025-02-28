<!DOCTYPE html>							
	<html lang="vi">							
	<head>							
        <meta charset="UTF-8">							
        <meta name="viewport" content="width=device-width, initial-scale=1.0">							
        <title>Product List</title>							
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">							
	</head>							
<body>
    <div class="container mt-5">
        <h2>Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add Product</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Avatar</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>
                        <img src="{{ $product['avatar'] }}" alt="Avatar" width="50" height="50">
                    </td>
                    <td>{{ \Carbon\Carbon::parse($product['createdAt'])->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>