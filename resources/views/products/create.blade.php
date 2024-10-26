@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-5" style="font-size: 2.5rem; font-weight: 700; color: #2c3e50;">Add New Product</h2>

    <div class="card p-5 shadow-lg">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="form-group">
                <label for="name" class="font-weight-bold">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter product name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category" class="font-weight-bold mt-3">Category <span class="text-danger">*</span></label>
                <select class="form-control" id="category" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Subcategory -->
            <div class="form-group">
                <label for="subcategory_id" class="font-weight-bold mt-3">Subcategory <span class="text-danger">*</span></label>
                <select class="form-control" id="subcategory_id" name="subcategory_id">
                    <option value="">Select Subcategory</option>
                </select>
                @error('subcategory_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="font-weight-bold mt-3">Description <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter product description"></textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Old Price -->
            <div class="form-group">
                <label for="old_price" class="font-weight-bold mt-3">Old Price</label>
                <input type="number" class="form-control @error('old_price') is-invalid @enderror" name="old_price" step="0.01" placeholder="Enter old price">
                @error('old_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- New Price -->
            <div class="form-group">
                <label for="new_price" class="font-weight-bold mt-3">New Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('new_price') is-invalid @enderror" name="new_price" step="0.01" placeholder="Enter new price">
                @error('new_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Product Images -->
            <div class="form-group mt-4">
                <label for="images" class="font-weight-bold">Product Images <span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="images" name="file[]" multiple required>
                    <label class="custom-file-label" for="images">Choose images...</label>
                </div>
                <small class="form-text text-muted mt-2">You can select multiple images simultaneously.</small>
            </div>

            <!-- Buttons -->
            <div class="form-group text-center mt-5">
                <button type="submit" class="btn btn-lg btn-primary px-5">Save Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-lg btn-secondary px-5 ml-3">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/getSubcategories/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategory_id').empty();
                        $('#subcategory_id').append('<option value="">Select Subcategory</option>');
                        $.each(data, function(key, value) {
                            $('#subcategory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory_id').empty();
                $('#subcategory_id').append('<option value="">Select Subcategory</option>');
            }
        });
    });
</script>
@endsection
