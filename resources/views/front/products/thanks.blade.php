<?php use App\Models\Product;?>
@extends('front.layout.layout')

@section('title', 'View Cart')

@section('content')
   <!-- Page Introduction Wrapper -->
   <div class="page-style-a">
    <div class="container">
        <div class="page-intro" >
            <h2>Cart</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="#">Thanks</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
      <!-- Cart-Page -->
      <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">
               <div class="col-lg-12" align="center">
                <h3>You Order has Been Place Successfully</h3>
                <p>
                    Your Order number is {{ Session::get('order_id') }} and Grand Total is Rs.{{ Session::get('grand_total') }}
                </p>
               </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Cart-Page /- -->

@endsection

<?php 
Session::forget('grand_total');
Session::forget('order_id');
Session::forget('couponCode');
Session::forget('CouponAmount');
?>
