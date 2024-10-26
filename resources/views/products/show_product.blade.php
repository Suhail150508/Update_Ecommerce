@extends('layouts.app')

@section('content')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <body data-sidebar="dark" data-layout-mode="light">

        <!-- Begin page -->
        <div id="layout-wrapper" class="container">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
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
                        <!-- end page title -->


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
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end row -->

                         <!-- Pagination Links -->
                        <div class="d-flex justify-content-center" style="margin-top: 5rem">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

        </div>
        <!-- END layout-wrapper -->


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
                                $('#subcategory_id').empty(); // Clear the subcategory dropdown
                                $('#subcategory_id').append('<option value="">Select Subcategory</option>'); // Default option
                                
                                $.each(data, function(key, value) {
                                    $('#subcategory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#subcategory_id').empty(); // If no category is selected, clear subcategories
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
                                $('#productsDisplay').html(data.html); // Update product display
                            }
                        });
                    }
                });
            });

        </script>

@endsection
