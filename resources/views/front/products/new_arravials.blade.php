<?php use App\Models\Product;?>
@extends('front.layout.layout')
@section('title', 'New Arravials Product')

@section('content')

    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>New Arrivals</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="listing-without-filters.html">New Arrivals</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Custom-Deal-Page -->
    <div class="page-deal u-s-p-t-80">
        <div class="container">
            <div class="deal-page-wrapper">
                <h1 class="deal-heading">New Arrivals</h1>
                <h6 class="deal-has-total-items">27 Items</h6>
            </div>
            <!-- Page-Bar -->
            <div class="page-bar clearfix">
                <div class="shop-settings">
                    <a id="list-anchor">
                        <i class="fas fa-th-list"></i>
                    </a>
                    <a id="grid-anchor" class="active">
                        <i class="fas fa-th"></i>
                    </a>
                </div>
                <!-- Toolbar Sorter 1  -->
                <div class="toolbar-sorter">
                    <div class="select-box-wrapper">
                        <label class="sr-only" for="sort-by">Sort By</label>
                        <select class="select-box" id="sort-by">
                            <option selected="selected" value="">Sort By: Best Selling</option>
                            <option value="">Sort By: Latest</option>
                            <option value="">Sort By: Lowest Price</option>
                            <option value="">Sort By: Highest Price</option>
                            <option value="">Sort By: Best Rating</option>
                        </select>
                    </div>
                </div>
                <!-- //end Toolbar Sorter 1  -->
                <!-- Toolbar Sorter 2  -->
                <div class="toolbar-sorter-2">
                    <div class="select-box-wrapper">
                        <label class="sr-only" for="show-records">Show Records Per Page</label>
                        <select class="select-box" id="show-records">
                            <option selected="selected" value="">Show: 8</option>
                            <option value="">Show: 16</option>
                            <option value="">Show: 28</option>
                        </select>
                    </div>
                </div>
                <!-- //end Toolbar Sorter 2  -->
            </div>
            <!-- Page-Bar /- -->
            <!-- Row-of-Product-Container -->
            <div class="row product-container grid-style">
                @foreach ($newProducts as $product )
                <?php $product_image_path='front/images/product_image/small/'.$product['product_image'];?>
                <div class="product-item col-lg-3 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="image-container">
                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                @if(!empty($product['product_image'])&&file_exists($product_image_path))
                                <img class="img-fluid" src="{{ asset($product_image_path)}}" alt="Product">
                                @else
                                <img class="img-fluid" src="{{ asset('front/images/product_image/small/no-image.png')}}" alt="Product">
                                @endif
                            </a>
                            <div class="item-action-behaviors">
                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="what-product-is">
                                <ul class="bread-crumb">
                                    <li class="has-separator">
                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                    </li>
                                    <li class="has-separator">
                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_color'] }}</a>
                                    </li>
                                    <li>
                                        <a href="shop-v3-sub-sub-category.html">{{ $product['brand']['name'] }}</a>
                                    </li>
                                </ul>
                                <h6 class="item-title">
                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                </h6>
                                <div class="item-description">
                                    <p> {{ $product['description'] }}</p>
                                </div>
                                <div class="item-stars">
                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                        <span style='width:67px'></span>
                                    </div>
                                    <span>(23)</span>
                                </div>
                            </div>
                            <?php $getDiscountPrice= Product::getDiscountPrice($product['id'])?>
                            @if($getDiscountPrice>0)
                            <div class="price-template">
                                <div class="item-new-price">
                                    Rs. {{ $getDiscountPrice }}
                                </div>
                                <div class="item-old-price">
                                    Rs. {{ $product['product_price'] }}
                                </div>
                            </div>
                            @else
                            <div class="price-template">
                                <div class="item-new-price">
                                    Rs.{{ $product['product_price'] }}
                                </div>
                            </div>
                            @endif
                        </div>
                        <?php $isProductNew=Product::isProductNew($product['id']); ?>
                        @if($isProductNew =="Yes")
                        <div class="tag new">
                            <span>NEW</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Row-of-Product-Container /- -->
            <!-- Shop-Pagination -->
            <div>{{ $newProducts->links() }}</div>
            <!-- Shop-Pagination /- -->
        </div>
    </div>
    <!-- Custom-Deal-Page -->
@endsection
