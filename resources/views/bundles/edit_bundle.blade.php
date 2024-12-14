@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-5 shadow-lg border-0 rounded-3">
            <h2 class="text-center mb-4 text-primary fw-bold">Update Bundle</h2>
        
            <form action="{{ route('bundle.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Add this for updating resources -->
                
                <!-- Bundle Name -->
                <input type="hidden" name="id" value="{{  $bundle->id }}">
                <div class="form-group mb-4">
                    <label for="name" class="fw-semibold">Bundle Name <span class="text-danger">*</span></label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter bundle name"
                           value="{{ old('name', $bundle->name) }}">
            
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Select Products -->
                {{-- <div class="form-group mb-4">
                    <label class="fw-semibold">Select Products <span class="text-danger">*</span></label>
                    <div class="border rounded p-3" style="height: 200px; overflow-y: auto; border: 1px solid black;">
                        @foreach($products as $product)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="product_ids[]"
                                       value="{{ $product->id }}"
                                       id="product_{{ $product->id }}"
                                       @if(is_array(old('product_ids', $bundle->products->pluck('id')->toArray())) && in_array($product->id, old('product_ids', $bundle->products->pluck('id')->toArray()))) checked @endif>
                                <label class="form-check-label" for="product_{{ $product->id }}">
                                    {{ $product->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
            
                    @error('product_ids')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                 --}}

                 <div class="form-group mb-4">
                    <label class="fw-semibold">Select Products <span class="text-danger">*</span></label>
                    
                    <!-- Search Input -->
                    <input type="text" id="product-search" class="form-control mb-3" placeholder="Search products...">
                
                    <!-- Products List -->
                    <div class="border rounded p-3" style="height: 200px; overflow-y: auto; border: 1px solid black;">
                        @foreach($products as $product)
                            <div class="form-check product-item">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="product_ids[]"
                                       value="{{ $product->id }}"
                                       id="product_{{ $product->id }}"
                                       @if(is_array(old('product_ids', $bundle->products->pluck('id')->toArray())) && in_array($product->id, old('product_ids', $bundle->products->pluck('id')->toArray()))) checked @endif>
                                <label class="form-check-label" for="product_{{ $product->id }}">
                                    {{ $product->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                
                    @error('product_ids')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                

                <!-- discount_type -->
                <div class="form-group mb-4">
                    <label>{{ __('discount_type') }} <span class="text-danger">*</span></label>
                    <select name="discount_type" class="form-control">
                        <option value="Percentage" @if(old('discount_type', $bundle->status) === 'Percentage') selected @endif>{{ __('Percentage') }}</option>
                        <option value="Fixed" @if(old('status', $bundle->status) === 'Fixed') selected @endif>{{ __('admin.Fixed') }}</option>
                    </select>
                </div>
                
                <!-- Price -->
                <div class="form-group mb-4">
                    <label for="price">Price <span class="text-danger">*</span></label>
                    <input type="number"
                           id="price"
                           name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           placeholder="Enter price"
                           value="{{ old('price', $bundle->price) }}"
                           min="0" step="0.01">
            
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        <i class="bi bi-save me-2"></i>Update Bundle
                    </button>
                </div>
            </form>
            
        </div>
        
    </div>

    <script>

        document.getElementById('product-search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(function (item) {
                const productName = item.querySelector('label').textContent.toLowerCase();
                if (productName.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });


    </script>

@endsection
