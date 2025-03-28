@extends('master')

@section('content')
<div class="space50">&nbsp;</div>
<div class="container beta-relative">
    <div class="pull-left">
        <h2>List</h2>
    </div>

    <table id="table_admin_product" class="table table-striped display">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="products-list-admin">
                <th scope="row">{{ $product->id ?? 'N/A' }}</th>
                <td>
                    <img src="{{ $product->avatar ?? 'default.png' }}" alt="avatar" style="height: 100px;" />
                </td>
                <td>{{ $product->name ?? 'No name' }}</td>
                <td>{{ $product->description ?? 'No description available' }}</td>
                <td>{{ $product->price ?? '0' }}</td>
                <td>{{ $product->quantity ?? '0' }}</td>
                <td>{{ $product->created_at ? $product->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                <td>
                    <a href="{{ url('admin-edit-form/' . $product->id) }}" class="btn btn-warning" style="width:80px;">Edit</a>
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        <input type="number" name="price" value="{{ $product->price }}">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="space50">&nbsp;</div>
</div>

<script>
    $(document).ready(function() {
        $('#table_admin_product').DataTable();
    });
</script>

@endsection
