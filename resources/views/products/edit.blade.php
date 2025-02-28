<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>
        <form action="{{ route('products.update', $product['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $product['name'] }}" required class="form-control mb-3">
            <input type="url" name="avatar" value="{{ $product['avatar'] }}" required class="form-control mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>