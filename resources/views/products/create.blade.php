<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Product Name" required class="form-control mb-3">
            <input type="url" name="avatar" placeholder="Avatar URL" required class="form-control mb-3">
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</body>
</html>