<?php use App\Models\Product;?>

<div class="row product-container grid-list-style">
    @foreach ($vendorProducts as $product )
    <?php $product_image_path='front/images/product_image/small/'.$product['product_image'];?>

    <div class="product-item col-lg-4 col-md-6 col-sm-6">
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
                        <p>{{ $product['description'] }}</p>
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
