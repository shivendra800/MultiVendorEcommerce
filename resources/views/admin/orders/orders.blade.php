@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Management</h4>
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
                        <div class="table-responsive pt-3">
                            <table id="orders" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID </th>
                                        <th> Order Date </th>
                                        <th> Customer Name </th>
                                        <th> Customer Email </th>
                                        <th> Order Product </th>
                                        <th> Order Amount </th>
                                        <th> Order Status </th>
                                        <th> Payment Method </th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order )
                                   @if($order['orders_products'])

                                    <tr>
                                        <td>
                                            {{ $order['id'] }}
                                        </td>
                                        <td>
                                            {{  date('Y-m-d h:i:s',strtotime($order['created_at'])); }}
                                        </td>
                                        <td>{{ $order['name'] }}</td>
                                        <td>{{ $order['email'] }}</td>
                                        <td>
                                            @foreach($order['orders_products'] as $product)
                                            {{ $product['product_code'] }} {{ $product['product_qty'] }}<br>
                                            @endforeach
                                           </td>
                                           <td>{{ $order['grand_total'] }}</td>
                                           <td>{{ $order['order_status'] }}</td>
                                           <td>{{ $order['payment_method'] }}</td>
                                           <td>
                                            <a title="View Order Details" href="{{ url('admin/orders/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-document"></i></a>
                                            <a target="_blank" title="View Order Invoice" href="{{ url('admin/view-order-invoice/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-printer"></i></a>
                                            <a target="_blank" title="View Invoice Pdf" href="{{ url('admin/view-order-invoice-pdf/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-pdf"></i></a>

                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    {{-- @include('admin.layout.footer')

<!-- partial -->
</div> --}}
    @endsection
