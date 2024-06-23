<?php use App\Models\Product;
       use App\Models\OrdersLog;
?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> {{Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">View Order  Details</h3>

                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/orders') }}">Back</a></h6>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Details</h4>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Order ID:</label>
                            <label>{{ $orderDetails['id'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label tyle="font-weight: 550;">Order Date:</label>
                            <label>{{  date('Y-m-d h:i:s',strtotime($orderDetails['created_at'])); }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Order States:</label>
                            <label>{{ $orderDetails['order_status'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Order Total:</label>
                            <label>Rs.{{ $orderDetails['grand_total'] }}</label>
                        </div>
                         <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Shipping Charges:</label>
                            <label>Rs.{{ $orderDetails['shipping_charges'] }}</label>
                        </div>
                        @if(!empty($orderDetails['coupon_code']))
                         <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Coupon Code:</label>
                            <label>{{ $orderDetails['coupon_code'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Coupon Amount:</label>
                            <label>Rs.{{ $orderDetails['coupon_amount'] }}</label>
                        </div>
                        @endif
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Payment Method:</label>
                            <label>{{ $orderDetails['payment_method'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Payment Gateway:</label>
                            <label>{{ $orderDetails['payment_gateway'] }}</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Customer Information</h4>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Name:</label>
                            <label>{{ $userDetails['name'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Email:</label>
                            <label>{{ $userDetails['email'] }}</label>
                        </div>
                        @if(!empty($userDetails['address']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Address:</label>
                            <label>{{ $userDetails['address'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['city']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">City:</label>
                            <label>{{ $userDetails['city'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['state']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">State:</label>
                            <label>{{ $userDetails['state'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['country']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Country:</label>
                            <label>{{ $userDetails['country'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['pincode']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Pincode:</label>
                            <label>{{ $userDetails['pincode'] }}</label>
                        </div>
                        @endif
                        @if(!empty($userDetails['mobile']))
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Mobile:</label>
                            <label>{{ $userDetails['mobile'] }}</label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Delivery Address </h4>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Name:</label>
                            <label>{{ $orderDetails['name'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Email:</label>
                            <label>{{ $orderDetails['email'] }}</label>
                        </div>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Address:</label>
                            <label>{{ $orderDetails['address'] }}</label>
                        </div>

                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">City:</label>
                            <label>{{ $orderDetails['city'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">State:</label>
                            <label>{{ $orderDetails['state'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Country:</label>
                            <label>{{ $orderDetails['country'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Pincode:</label>
                            <label>{{ $orderDetails['pincode'] }}</label>
                        </div>
                        <div class="form-group" style="height: 15px;">
                            <label style="font-weight: 550;">Mobile:</label>
                            <label>{{ $orderDetails['mobile'] }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Order Status</h4>
                        @if(Auth::guard('admin')->user()->type!="vendor")
                          <form action="{{ url('admin/update-order-status') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                            <select name="order_status" id="order_status" required="">
                                @foreach ($orderStatuses as $status )
                                <option value="{{ $status['name'] }}" @if(!empty($orderDetails['order_status'])&& $orderDetails['order_status']==$status['name']) selected="" @endif> {{ $status['name'] }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="courier_name" id="courier_name" placeholder="Courier Name">
                            <input type="text" name="tracking_number" id="tracking_number" placeholder="Tracking Number">
                            <button type="submit">Update Order Status</button>
                        </form>
                        <br>
                        @foreach ($orderLog as $key => $log )
                        {{-- <?php echo "<pre>";print_r($log['orders_products'][$key]['product_code']);die; ?> --}}
                        <strong>{{ $log['order_status'] }}</strong>

                        @if(isset($log['order_item_id'])&& $log['order_item_id']>0)
                        @php $getItemDetails = OrdersLog::getItemDetails($log['order_item_id']) @endphp
                          -for item {{ $getItemDetails['product_code'] }}
                          @if(!empty($getItemDetails['item_courier_name']))
                          <br><span>Courier Name:: {{ $getItemDetails['item_courier_name'] }}</span>
                          @endif
                          @if(!empty($getItemDetails['item_tracking_number']))
                          <br><span>tracking Number:: {{ $getItemDetails['item_tracking_number'] }}</span>
                          @endif


                        @endif
                        <br>
                        {{  date('d-m-Y h:i:s',strtotime($log['created_at'])); }}<br>
                            <hr>
                        @endforeach
                        @else
                        This  Feature Is not For You.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ordered Products</h4>
                        <table class="table table-striped table-borderless">
                            <tr><td colspan="2"><strong>Product Details</strong></td></tr>
                               <tr>
                                <th>Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Product Size</th>
                                <th>Product Color</th>
                                <th>Product Qty</th>
                                <th>Added By</th>
                                <th>Item Status</th>
                               </tr>

                                @foreach ($orderDetails['orders_products'] as $product )
                                   <tr>
                                    <td>
                                        @php $getProductImage= Product::getProductImage($product['product_id']) @endphp
                                        <a href="{{ url('product/'.$product['product_id']) }}"><img  src="{{ asset('front/images/product_image/small/'.$getProductImage) }}"></a>
                                    </td>
                                    <td>{{ $product['product_code'] }}</td>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ $product['product_size'] }}</td>
                                    <td>{{ $product['product_color'] }}</td>
                                    <td>{{ $product['product_qty'] }}</td>
                                    <td>@if($product['vendor_id']>0)
                                       <strong style="color: red">{{ucfirst( 'Vendor') }}</strong>
                                        @else
                                        <strong style="color: orange">{{ucfirst( 'Admin') }}</strong>
                                        @endif</td>
                                    <td>  <form action="{{ url('admin/update-order-item-status') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                        <select name="order_item_status" id="order_item_status" required="">
                                            @foreach ($orderItemStatuses as $status )

                                            <option value="{{ $status['name'] }}" @if(!empty($product['item_status'])&& $product['item_status']==$status['name']) selected="" @endif> {{ $status['name'] }}</option>
                                            @endforeach
                                        </select> <br>
                                      <br>  <input style="width:100px;" type="text" name="item_courier_name" id="item_courier_name" @if(!empty($product['item_courier_name'])) value="{{ $product['item_courier_name'] }}" @endif placeholder="Courier Name"> <br>
                                      <br><input style="width:100px;" type="text" name="item_tracking_number" id="item_tracking_number" @if(!empty($product['item_tracking_number'])) value="{{ $product['item_tracking_number'] }}" @endif placeholder="Tracking Number"> <br>
                                      <br>  <button type="submit">Update Order Status</button>
                                    </form></td>

                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layout.footer')

    <!-- partial -->
</div>
@endsection
