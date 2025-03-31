@extends('master')

@section('content')
<div class="space50">&nbsp;</div>
<div class="container beta-relative">
    <div class="pull-left">
        <h2>Edit Product</h2>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product['product_id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="old_image" value="{{ $product['image'] }}">

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product['name']) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $product['description']) }}</textarea>
        </div>

        <div class="form-group">
            <label for="unitPrice">Price:</label>
            <input type="number" class="form-control" name="unitPrice" id="unitPrice" value="{{ old('unitPrice', $product['unitPrice']) }}" required>
        </div>

        <div class="form-group">
            <label for="promotionPrice">Promotion Price:</label>
            <input type="number" class="form-control" name="promotionPrice" id="promotionPrice" value="{{ old('promotionPrice', $product['promotionPrice']) }}">
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" name="image" id="image">
            <img src="{{ asset('storage/source/image/product/' . $product['image']) }}" alt="Product Image" style="height: 100px;">
        </div>

        <div class="form-group">
            <label for="unit">Unit:</label>
            <input type="text" class="form-control" name="unit" id="unit" value="{{ old('unit', $product['unit']) }}" required>
        </div>

        <div class="form-group">
            <label for="new">New Product:</label>
            <select class="form-control" name="new" id="new" required>
                <option value="1" {{ old('new', $product['new']) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('new', $product['new']) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Product</button>
    </form>

    <div class="space50">&nbsp;</div>
</div>
@endsection

