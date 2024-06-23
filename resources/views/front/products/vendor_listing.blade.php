<?php use App\Models\Product;?>

@extends('front.layout.layout')

@section('title', 'Vendor Product Details')

@section('content')


<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2> {{ $getVendorShop }}</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('/') }}"> {{ $getVendorShop }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Shop-Page -->
<div class="page-shop u-s-p-t-80">
    <div class="container">
        <!-- Shop-Intro -->
        <div class="shop-intro">
            <ul class="bread-crumb">
                <li class="has-separator">
                    <a href="{{ url('/') }}">Home</a>
                </li>
              <li> {{ $getVendorShop }}</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="page-bar clearfix">
                </div>
                    <div class="">
                        @include('front.products.vendor_products_listing')
                </div>
        </div>

    </div>
</div>
</div>

@endsection
