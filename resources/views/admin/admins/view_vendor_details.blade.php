@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">View Vendor Details</h3>

                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}">Back</a></h6>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Personal Information</h4>

                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" value="{{$vendorDetails['vendor_personal']['email'] }}" readonly="">
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['name']}}" placeholder="Enter Admin Name" readonly="">

                        </div>
                        <div class="form-group">
                            <label>Mobile No</label>
                            <input type="mobile" class="form-control" value="{{$vendorDetails['vendor_personal']['mobile'] }}" placeholder="Enter Mobile No." maxlength="10" minlength="10" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['address'] }}" placeholder="Enter Address." readonly="">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['city'] }}" placeholder="Enter City." readonly="">
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['state'] }}" placeholder="Enter State." readonly="">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" value="{{$vendorDetails['vendor_personal']['country'] }}" placeholder="Enter Country." readonly="">
                        </div>
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="number" class="form-control" value="{{$vendorDetails['vendor_personal']['pincode'] }}" placeholder="Enter Pincode." maxlength="6" minlength="6" readonly="">
                        </div>
                        @if(!empty($vendorDetails['image']))
                        <div class="form-group">
                            <label>Vendor Photo</label>
                            <br>
                            <img style="width:200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"></img>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Bussiness Information</h4>
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_name'])) value="{{ $vendorDetails['vendor_business']['shop_name'] }}" @endif placeholder="Enter Admin Name" readonly="">

                        </div>
                        <div class="form-group">
                            <label for="shop_mobile">Shop Mobile No</label>
                            <input type="mobile" class="form-control" id="shop_mobile" name="shop_mobile" @if(isset($vendorDetails['vendor_business']['shop_mobile'])) value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}" @endif placeholder="Enter Mobile No." maxlength="10" minlength="10" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_address">Shop Address</label>
                            <input type="text" class="form-control" id="shop_address" name="shop_address" @if(isset($vendorDetails['vendor_business']['shop_address'])) value="{{$vendorDetails['vendor_business']['shop_address'] }}" @endif placeholder="Enter Address." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_city">Shop City</label>
                            <input type="text" class="form-control" id="shop_city" name="shop_city" @if(isset($vendorDetails['vendor_business']['shop_city'])) value="{{$vendorDetails['vendor_business']['shop_city'] }}" @endif   placeholder="Enter City." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_state">Shop State</label>
                            <input type="text" class="form-control" id="shop_state" name="shop_state" @if(isset($vendorDetails['vendor_business']['shop_state'])) value="{{$vendorDetails['vendor_business']['shop_state'] }}" @endif placeholder="Enter State." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_country">Shop Country</label>
                            <input type="text" class="form-control" id="shop_country" name="shop_country" @if(isset($vendorDetails['vendor_business']['shop_country'])) value="{{$vendorDetails['vendor_business']['shop_country'] }}" @endif placeholder="Enter Country." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_pincode">Shop Pincode</label>
                            <input type="number" class="form-control" id="shop_pincode" name="shop_pincode"@if(isset($vendorDetails['vendor_business']['shop_pincode'])) value="{{$vendorDetails['vendor_business']['shop_pincode'] }}" @endif placeholder="Enter Pincode." maxlength="6" minlength="6" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_website">Shop Website</label>
                            <input type="text" class="form-control" id="shop_website" name="shop_website" @if(isset($vendorDetails['vendor_business']['shop_website'])) value="{{$vendorDetails['vendor_business']['shop_website'] }}" @endif placeholder="Enter Country." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="address_proof">Shop Address Proof</label>
                            <select class="form-control" id="address_proof" name="address_proof" readonly="">
                                <option value="Passport" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Passport" ) selected @endif>Passport</option>
                                <option value="Voting Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Voting Card" ) selected @endif>Voting Card</option>
                                <option value="Pan" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Pan" ) selected @endif>Pan</option>
                                <option value="Driving License" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Driving License" ) selected @endif>Driving License</option>
                                <option value="Aadhar Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Aadhar Card" ) selected @endif>Aadhar Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="business_license_number">Business License Number</label>
                            <input type="text" class="form-control" id="business_license_number" name="business_license_number"@if(isset($vendorDetails['vendor_business']['business_license_number'])) value="{{$vendorDetails['vendor_business']['business_license_number'] }}" @endif placeholder="Enter Country." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="gst_number">GST Number</label>
                            <input type="text" class="form-control" id="gst_number" name="gst_number" @if(isset($vendorDetails['vendor_business']['gst_number'])) value="{{$vendorDetails['vendor_business']['gst_number'] }}" @endif placeholder="Enter Country." readonly="">
                        </div>
                        <div class="form-group">
                            <label for="pan_number">Pan Number</label>
                            <input type="text" class="form-control" id="pan_number" name="pan_number" @if(isset($vendorDetails['vendor_business']['pan_number'])) value="{{$vendorDetails['vendor_business']['pan_number'] }}" @endif placeholder="Enter Country." readonly="">
                        </div>
                        @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                        <div class="form-group">
                            <label>Address Proof Image</label>
                            <br>
                            <img style="width:200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"></img>

                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Bank Information</h4>

                        <div class="form-group">
                            <label for="account_holder_name">Account Holder Name</label>
                            <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" @endif placeholder="Enter Admin Name" readonly="">

                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="mobile" class="form-control" id="account_number" name="account_number" @if(isset($vendorDetails['vendor_bank']['account_number'])) value="{{ $vendorDetails['vendor_bank']['account_number'] }}" @endif  placeholder="Enter Bank Account  No."  readonly="">
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" @if(isset($vendorDetails['vendor_bank']['bank_name'])) value="{{$vendorDetails['vendor_bank']['bank_name'] }}" @endif placeholder="Enter Bank Name."  readonly="">
                        </div>
                        <div class="form-group">
                            <label for="bank_ifsc_code">Bank_Ifsc_Code</label>
                            <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code" @if(isset($vendorDetails['vendor_bank']['bank_ifsc_code'])) value="{{$vendorDetails['vendor_bank']['bank_ifsc_code'] }}" @endif placeholder="Enter Bank IFSC Code." readonly="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layout.footer')

    <!-- partial -->
</div>
@endsection
