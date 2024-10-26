@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4 text-center text-primary">Edit Product</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="form-group mb-4">
                <label for="name" class="font-weight-bold">Product Name</label>
                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Category -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="category">Category</label>
                <select class="form-control form-control-lg" id="category" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Subcategory -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="subcategory_id">Subcategory</label>
                <select class="form-control form-control-lg @error('subcategory_id') is-invalid @enderror" name="subcategory_id">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('subcategory_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="description">Description</label>
                <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Old Price -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="old_price">Old Price</label>
                <input type="number" class="form-control form-control-lg @error('old_price') is-invalid @enderror" name="old_price" step="0.01" value="{{ old('old_price', $product->old_price) }}" placeholder="Enter old price">
                @error('old_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- New Price -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="new_price">New Price</label>
                <input type="number" class="form-control form-control-lg @error('new_price') is-invalid @enderror" name="new_price" step="0.01" value="{{ old('new_price', $product->new_price) }}" placeholder="Enter new price">
                @error('new_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Existing Images -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="existing_images">Existing Images</label>
                <div class="d-flex flex-wrap mt-2">
                    @foreach(explode('|', $product->image) as $image)
                        @if($image)
                            <div class="image-wrapper position-relative mr-2 mb-2">
                                <img src="{{ asset('image/' . $image) }}" class="rounded-circle" width="60" height="60">
                                <button class="delete-image position-absolute" 
                                        data-product-id="{{ $product->id }}" 
                                        data-image="{{ $image }}" 
                                        style="top: 0; right: 0; background: none; border: none;">
                                    <i class="bx bx-x text-danger" style="font-size: 1.5rem;"></i>
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Upload New Images -->
            <div class="form-group mb-4">
                <label class="font-weight-bold" for="images">Update Product Images</label>
                <input type="file" class="form-control-file @error('images.*') is-invalid @enderror" id="images" name="file[]" multiple>
                @error('images.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-lg btn-primary px-5">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-lg btn-secondary px-5">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-image').on('click', function(e) {
            e.preventDefault(); // Prevent default action, if any
            
            const button = $(this);
            const productId = button.data('product-id');
            const imageName = button.data('image');
    
            $.ajax({
                url: `/product/${productId}/image/${imageName}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    button.closest('.image-wrapper').remove(); // Remove the deleted image wrapper from the DOM
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
