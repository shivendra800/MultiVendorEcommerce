<?php
use App\Models\Section;
 use App\Models\Product;
$sections=Section::sections();
// echo "<pre>";print_r($sections);die;
    $totalCartItems=totalCartItems();
    $getCartItems=getCartItems();
?>


    <div class="mini-cart-wrapper">
        <div class="mini-cart">
            <div class="mini-cart-header">
                YOUR CART
                <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
            </div>
            <ul class="mini-cart-list">
                @php $total_price=0 @endphp
                @foreach ($getCartItems as $item )
                <?php $getDiscountAttributePrice =Product::getDiscountAttributePrice($item['product_id'],$item['size']);
               // echo"<pre>";print_r($getDiscountAttributePrice); die;
            ?>
                <li class="clearfix">
                    <a href="{{ url('product/'.$item['product_id']) }}">
                        <img src="{{ asset('front/images/product_image/small/'.$item['product']['product_image']) }}" alt="Product">
                        <span class="mini-item-name">{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }}) -
                            {{ $item['size'] }}<br>
                            Color: {{ $item['product']['product_color'] }}<br></span>
                        <span class="mini-item-price"> Rs.{{ $getDiscountAttributePrice['final_price'] }}</span>
                        <span class="mini-item-quantity"> {{  $item['quantity'] }} </span>
                    </a>
                </li>
                @php $total_price =  $total_price + ( $getDiscountAttributePrice['final_price'] *$item['quantity']) @endphp
                @endforeach
            </ul>
            <div class="mini-shop-total clearfix">
                <span class="mini-total-heading float-left">Total:</span>
                <span class="mini-total-price float-right">Rs.{{ $total_price }} </span>
            </div>
            <div class="mini-action-anchors">
                <a href="{{ url('cart') }}" class="cart-anchor">View Cart</a>
                <a href="{{ url('checkout') }}" class="checkout-anchor">Checkout</a>
            </div>
        </div>
    </div>
    <!-- Mini Cart /- -->
    <script>
        //    $('#mini-cart-close').on('click', function () {
        //     $('.mini-cart-wrapper').removeClass('mini-cart-open');
        // });
    </script>
