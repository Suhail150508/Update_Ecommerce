{{-- @extends('layouts.app')

@section('content')


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <body data-sidebar="dark" data-layout-mode="light">


        <div id="layout-wrapper" class="container">

                <div class="page-content">
                    <div class="container-fluid">

                  
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin-top: -4rem; ">
                                    <h4 class="mb-sm-0 font-size-18">Search Products</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Products</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                     

                        <div>

                            <form action="{{ url('/filter-products') }}" method="POST" id="filter-form" style="margin-bottom: 4rem; background-color: #f7f9fc; padding: 2rem; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                                @csrf
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category" class="form-label font-weight-bold">Category</label>
                                            <select class="form-control custom-select" id="category" name="category_id">
                                                <option value="">Select All Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{session('selectedCategoryId') == $category->id? 'selected' : ''}}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_id" class="form-label font-weight-bold">Subcategory</label>
                                            <select class="form-control custom-select" id="subcategory_id" name="subcategory_id">
                                                <option value="">Select All Subcategory</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end" style="margin-top:1.8rem">
                                        <button type="submit" class="btn btn-success w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    @foreach ($products as $product )

                                    @php

                                        $old_price = $product->old_price ?? 0; 
                                        $new_price = $product->new_price ?? 0; 
                                        
                                        $difference = $old_price > 0 ? (($old_price - $new_price) / $old_price) * 100 : 0;
                                    @endphp

                                        <div class="col-xl-3 col-sm-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="product-img position-relative">
                                                        <a href="{{route('products.show',$product->slug )}}">
                                                            <div class="avatar-sm product-ribbon">
                                                                <span class="avatar-title rounded-circle  bg-primary">

                                                                    -{{round($difference)}}%
                                                                </span>
                                                            </div>
                                                            @if(count($product->image) > 0)
                                                                @foreach ($product->image as $image)
                                                                    @if($image)
                                                                        <img src="{{ asset('image/' . $image) }}" alt="" class="img-fluid mx-auto d-block" style="height: 260px;width:200px">
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <p>No image</p>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="mt-4 text-center">
                                                        <h3 class="mb-3 text-truncate"><a href="{{route('products.show',$product->slug )}}" class="text-dark">{{$product->name}} </a></h5>
                                                        
                                                        <p class="text-muted">
                                                           {{$product->description}}
                                                        </p>
                                                        <h5 class="my-0"><span class="text-muted me-2"><del>${{$product->old_price}}</del></span> <b>${{$product->new_price}}</b></h5>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @endforeach
                                </div>
                               
                            </div>
                        </div>
                   
                        <div class="d-flex justify-content-center" style="margin-top: 5rem">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div> 
                </div>
              

        </div>
     


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

                $('#subcategory_id').on('change', function() {
                    var subcategoryId = $(this).val();
                    if (subcategoryId) {
                        $.ajax({
                            url: '/filter-products/' + subcategoryId,
                            type: 'GET',
                            success: function(data) {
                                $('#productsDisplay').html(data.html); 
                            }
                        });
                    }
                });
            });

        </script>

@endsection --}}






@extends('layouts.app')

@section('content')


{{-- Include necessary styles --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css" rel="stylesheet" />

<body data-sidebar="dark" data-layout-mode="light">

    <div id="layout-wrapper" class="">

        
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin-top: -4rem;">
                        <h4 class="mb-sm-0 font-size-18">Search Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter and Products Section -->
            <div class="row">
                <!-- Filter by Price -->
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <strong>Filter by Price</h5>
                            <div id="price-range"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <span id="min-price"></span>
                                <span id="max-price"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product List -->
                <div class="col-md-9">
                    <div id="product-list">
                        <div class="row">
                            @foreach ($products as $product)

                            @php
                                $old_price = $product->old_price ?? 0;
                                $new_price = $product->new_price ?? 0;
                                $difference = $old_price > 0 ? (($old_price - $new_price) / $old_price) * 100 : 0;
                            @endphp

                                <div class="col-xl-3 col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="product-img position-relative">
                                                <a href="{{ route('products.show', $product->slug) }}">

                                                    @if($difference > 0)
                                                    <div class="avatar-sm product-ribbon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            -{{ round($difference) }}%
                                                        </span>
                                                    </div>
                                                    @endif

                                                    <!-- Product Image -->
                                                    @if(is_array($product->image) && count($product->image) > 0)
                                                        <img src="{{ asset('image/' . $product->image[0]) }}" alt="" class="img-fluid mx-auto d-block" style="height: 210px;width:200px">
                                                    @elseif(is_string($product->image))
                                                        <img src="{{ asset('image/' . $product->image) }}" alt="" class="img-fluid mx-auto d-block" style="height: 260px;width:200px">
                                                    @else
                                                        <p>No image</p>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <h3 class="mb-3 text-truncate">
                                                    <a href="{{ route('products.show', $product->slug) }}" class="text-dark">{{ $product->name }}</a>
                                                </h3>
                                                <h5 class="my-0">
                                                    <span class="text-muted me-2"><del>${{ $product->old_price }}</del></span>
                                                    <b>${{ $product->new_price }}</b>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>


                        {{-- <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
                                    <li class="page-item disabled">
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </li>
                                </ul>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
        
    </div>

    {{-- Include necessary scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var priceSlider = document.getElementById('price-range');
            noUiSlider.create(priceSlider, {
                start: [0, 1000],
                connect: true,
                range: {
                    'min': 0,
                    'max': 1000
                },
                tooltips: [true, true],
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return value;
                    }
                }
            });

            var minPrice = document.getElementById('min-price');
            var maxPrice = document.getElementById('max-price');
            priceSlider.noUiSlider.on('update', function(values) {
                minPrice.innerHTML = '$' + values[0];
                maxPrice.innerHTML = '$' + values[1];
            });

            priceSlider.noUiSlider.on('change', function(values) {
                var minPrice = values[0];
                var maxPrice = values[1];

                $.ajax({
                    url: '/filter-products',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        min_price: minPrice,
                        max_price: maxPrice
                    },
                    success: function(response) {
                        $('#product-list').html(response.html); 
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
    </script>

</body>


@endsection
