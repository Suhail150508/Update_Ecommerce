@extends('layouts.app')

@section('content')

<body data-sidebar="dark" data-layout-mode="light">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Product Detail</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                    <li class="breadcrumb-item active">Product Detail</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left side for thumbnails -->
                                    <div class="col-md-6">
                                        <div class="product-detai-imgs">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-3 col-4">
                                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                        @foreach ($product->image as $image)
                                                            @if($image)
                                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="product-{{ $loop->index }}-tab" data-bs-toggle="pill" href="#product-{{ $loop->index }}" role="tab" aria-controls="product-{{ $loop->index }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                    <img class="img-fluid mx-auto d-block rounded" src="{{ asset('image/' . $image) }}" alt="img">
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                                    <div class="tab-content" id="v-pills-tabContent">
                                                        <!-- Main Image View -->
                                                        @foreach ($product->image as $image)
                                                            @if($image)
                                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="product-{{ $loop->index }}" role="tabpanel" aria-labelledby="product-{{ $loop->index }}-tab">
                                                                    <img class="img-fluid mx-auto d-block" src="{{ asset('image/' . $image) }}" alt="img">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right side for product details -->
                                    <div class="col-md-6">
                                        <div class="mt-4 mt-xl-3">
                                            <p class="text-primary" style="color: black"><span style="color: black">Category:</span> {{ $product->category->name }}</p>
                                            <p class="text-primary" style="color: black"><span style="color: black">Sub_Category:</span> {{ $product->subcategory->name }}</p>
                                            <h4 class="mt-1 mb-3">{{ $product->name }}</h4>
                                            <h5 class="mb-4">Price : <span class="text-muted me-2"><del>${{ $product->old_price }}</del></span> <b>${{ $product->new_price }}</b></h5>
                                            <p class="text-muted mb-4">{{ $product->description }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- END layout-wrapper -->
@endsection
