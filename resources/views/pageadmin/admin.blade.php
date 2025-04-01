@extends('master')

@section('content')
<div class="space50">&nbsp;</div>
<div class="container beta-relative">
    <div class="pull-left">
        <h2>Product List</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <table class="table table-striped table-responsive" id="table_admin_product">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <th scope="row">{{ $product['product_id'] }}</th>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['description'] ?? 'No description' }}</td>
                <td>{{ number_format($product['unitPrice'], 0, ',', '.') }} VND</td>
                <td>
                    @if($product['image'])
                        <img src="{{ asset('source/image/product/' . $product['image']) }}" alt="Product Image" style="height: 100px;">
                    @else
                        <span>No image</span>
                    @endif
                </td>
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

    <div class="space50">&nbsp;</div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_admin_product').DataTable({
            responsive: true
        });
    });
</script>
@endsection

