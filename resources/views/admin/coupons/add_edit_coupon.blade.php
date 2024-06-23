@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Add Coupon</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">{{   $title }}</h4>
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

                        {{-- error meg with close button---- --}}
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        {{-- error meg --}}
                        <form class="forms-sample" @if(empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}"
                            @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                            @csrf
                               @if(empty($coupon['coupon_code']))
                           <div class="form-group">
                                <label for="coupon_option">Coupon Option</label><br>
                                <span><input type="radio" id="AutomaticCoupon" name="coupon_option" value="Automatic" checked="">&nbsp;Automatic&nbsp;&nbsp;</span>
                                <span><input type="radio" id="ManualCoupon" name="coupon_option" value="Manual">&nbsp;Manual&nbsp;&nbsp;</span>
                            </div>
                            <div class="form-group" style="display: none;" id="couponField">
                                <label for="coupon_code">Coupon Code</label>
                                <input type="text" class="form-control" name="coupon_code" placeholder="Enter coupon Code" name="coupon_name" >

                            </div>
                            @else
                                        <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                                        <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                                        <div class="form-group">
                                            <label for="coupon_code">Coupon Code</label><br>
                                            <span>{{ $coupon['coupon_code'] }}</span>
                                        </div>
                            @endif
                            <div class="form-group">
                                <label for="coupon_type">Coupon Type</label><br>
                                <span><input type="radio"  name="coupon_type" value="Multiple Times"  @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Multiple Times") checked=""  @endif>&nbsp;Multiple Times&nbsp;&nbsp;</span>
                                <span><input type="radio"  name="coupon_type" value="Single Times" @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Single Times") checked=""  @endif>&nbsp;Single Times&nbsp;&nbsp;</span>
                            </div>
                            <div class="form-group">
                                <label for="amount_type">Amount Type</label><br>
                                <span><input type="radio"  name="amount_type" value="Percentage" checked="">&nbsp;Percentage&nbsp;&nbsp;(in %)</span>
                                <span><input type="radio"  name="amount_type" value="Fixed">&nbsp;Fixed&nbsp;&nbsp;(in INR or USD)</span>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount" @if(!empty($coupon['amount'])) value="{{ $coupon['amount'] }}" @else value="{{ old('amount') }}" @endif placeholder="Enter coupon Price " >
                            </div>
                            <div class="form-group">
                                <label for="categories">Select category</label>
                                <select class="form-control text-dark"  name="categories[]"" multiple="" >

                                    @foreach ($categories as $section )
                                    <optgroup label="{{ $section['name']}}"></optgroup>
                                    @foreach ($section['categories'] as $category)
                                    <option   value={{ $category['id'] }} @if(in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;---&nbsp;{{ $category['category_name'] }}</option>
                                    @foreach ($category['subcategories'] as $subcategory)
                                    <option  value={{ $subcategory['id'] }} @if(in_array($subcategory['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brands">Select Brand</label>
                                <select class="form-control text-dark"  name="brands[]" multiple="">
                                    @foreach ($brands as $brand )
                                    <option @if(in_array($brand['id'],$selBrands)) selected="" @endif value="{{ $brand['id']}}">
                                        {{ $brand['name'] }}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="users">Select User</label>
                                <select class="form-control text-dark"  name="users[]" multiple="">
                                    @foreach ($users as $user )
                                    <option @if(in_array($user['email'],$selUsers)) selected="" @endif  value="{{ $user['email']}}" >
                                        {{ $user['email'] }}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expire_date">Expire Date</label>
                                <input type="date" class="form-control" name="expire_date" id="expire_date" @if(!empty($coupon['expire_date'])) value="{{ $coupon['expire_date'] }}" @else value="{{ old('expire_date') }}" @endif placeholder="Enter Expire Date " >
                            </div>


                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>







        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')

        <!-- partial -->
    </div>
    @endsection
