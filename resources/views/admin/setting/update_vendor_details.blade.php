@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>

                    </div>

                </div>
            </div>
        </div>
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Update Personal Information</h4>
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
                        <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Vendor Username/Email</label>
                                <input class="form-control" value="{{Auth::guard('admin')->user()->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="vendor_name">Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{Auth::guard('admin')->user()->name }}" placeholder="Enter Admin Name" required>

                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Mobile No</label>
                                <input type="mobile" class="form-control" id="vendor_mobile" name="vendor_mobile" value="{{Auth::guard('admin')->user()->mobile }}" placeholder="Enter Mobile No." maxlength="10" minlength="10" required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_address">Address</label>
                                <input type="text" class="form-control" id="vendor_address" name="vendor_address" value="{{$vendorDetails['address'] }}" placeholder="Enter Address." required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_city">City</label>
                                <input type="text" class="form-control" id="vendor_city" name="vendor_city" value="{{$vendorDetails['city'] }}" placeholder="Enter City." required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_state">State</label>
                                <input type="text" class="form-control" id="vendor_state" name="vendor_state" value="{{$vendorDetails['state'] }}" placeholder="Enter State." required>
                            </div>
                            <div class="form-group">
                                <label for="vendor_country">Country</label>
                                {{-- <input type="text" class="form-control" id="vendor_country" name="vendor_country" value="{{$vendorDetails['country'] }}" placeholder="Enter Country." required> --}}
                                <select class="form-control" id="vendor_country" name="vendor_country">
                                    <option>Select Country</option>
                                    @foreach ($countries as $country )
                                    <option value="{{ $country['country_name']}}" @if($country['country_name']==$vendorDetails['country']) selected @endif>
                                        {{ $country['country_name'] }}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="vendor_pincode">Pincode</label>
                                <input type="number" class="form-control" id="vendor_pincode" name="vendor_pincode" value="{{$vendorDetails['pincode'] }}" placeholder="Enter Pincode." maxlength="6" minlength="6" required>

                            </div>
                            <div class="form-group">
                                <label for="vendor_image">Vendor Photo</label>
                                <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                                @if(!empty(Auth::guard('admin')->user()->image))
                                <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                                <input type="hidden" name="current_vendor_image" value="{{Auth::guard('admin')->user()->image  }}">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>







            @elseif($slug=="business")
            <div class="row">
                {{-- <div class="col-md-3"></div> --}}
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Update Bussiness Information</h4>
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
                            <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="shop_email">Vendor Username/Email</label>
                                    <input class="form-control" name="shop_email" id="shop_email" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="shop_name">Shop Name</label>
                                    <input type="text" class="form-control" name="shop_name" id="shop_name" @if(isset( $vendorDetails['shop_name'])) value="{{ $vendorDetails['shop_name'] }}" @endif placeholder="Enter Admin Name" required>

                                </div>
                                <div class="form-group">
                                    <label for="shop_mobile">Shop Mobile No</label>
                                    <input type="mobile" class="form-control" id="shop_mobile" name="shop_mobile" @if(isset( $vendorDetails['shop_mobile'])) value="{{ $vendorDetails['shop_mobile'] }}" @endif placeholder="Enter Mobile No." maxlength="10" minlength="10" required>


                                </div>
                                <div class="form-group">
                                    <label for="shop_address">Shop Address</label>
                                    <input type="text" class="form-control" id="shop_address" name="shop_address" @if(isset($vendorDetails['shop_address'])) value="{{$vendorDetails['shop_address'] }}" @endif placeholder="Enter Address." required>


                                </div>
                                <div class="form-group">
                                    <label for="shop_city">Shop City</label>
                                    <input type="text" class="form-control" id="shop_city" name="shop_city" @if(isset( $vendorDetails['shop_city'])) value="{{$vendorDetails['shop_city'] }}" @endif placeholder="Enter City." required>


                                </div>
                                <div class="form-group">
                                    <label for="shop_state">Shop State</label>
                                    <input type="text" class="form-control" id="shop_state" name="shop_state" @if(isset($vendorDetails['shop_state'])) value="{{$vendorDetails['shop_state'] }}" @endif placeholder="Enter State." required>


                                </div>
                                <div class="form-group">
                                    <label for="shop_country">Shop Country</label>
                                    {{-- <input type="text" class="form-control" id="shop_country" name="shop_country" @if(isset($vendorDetails['account_holder_name'])) value="{{$vendorDetails['shop_country'] }}" placeholder="Enter Country." required> --}}
                                    <select class="form-control" id="shop_country" name="shop_country">
                                        <option>Select Country</option>
                                        @foreach ($countries as $country )
                                        <option value="{{ $country['country_name']}}" @if(isset($country['country_name']) && $country['country_name'])==$vendorDetails['shop_country']) selected @endif>
                                            {{ $country['country_name'] }}</option>

                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shop_pincode">Shop Pincode</label>
                                    <input type="number" class="form-control" id="shop_pincode" name="shop_pincode" @if(isset($vendorDetails['shop_pincode'])) value="{{$vendorDetails['shop_pincode'] }}" @endif placeholder="Enter Pincode." maxlength="6" minlength="6" required>

                                </div>
                                <div class="form-group">
                                    <label for="shop_website">Shop Website</label>
                                    <input type="text" class="form-control" id="shop_website" name="shop_website" @if(isset($vendorDetails['shop_website'])) value="{{$vendorDetails['shop_website'] }}" @endif placeholder="Enter Country." required>
                                </div>
                                <div class="form-group">
                                    <label for="address_proof">Shop Address Proof</label>
                                    <select class="form-control" id="address_proof" name="address_proof">
                                        <option value="Passport" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Passport" ) selected @endif>Passport</option>
                                        <option value="Voting Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Voting Card" ) selected @endif>Voting Card</option>
                                        <option value="Pan" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Pan" ) selected @endif>Pan</option>
                                        <option value="Driving License" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Driving License" ) selected @endif>Driving License</option>
                                        <option value="Aadhar Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Aadhar Card" ) selected @endif>Aadhar Card</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="business_license_number">Business License Number</label>
                                    <input type="text" class="form-control" id="business_license_number" name="business_license_number" @if(isset($vendorDetails['business_license_number'])) value="{{$vendorDetails['business_license_number'] }}" @endif placeholder="Enter Country." required>
                                </div>
                                <div class="form-group">
                                    <label for="gst_number">GST Number</label>
                                    <input type="text" class="form-control" id="gst_number" name="gst_number" @if(isset($vendorDetails['gst_number'])) value="{{$vendorDetails['gst_number'] }}" @endif placeholder="Enter Country." required>
                                </div>
                                <div class="form-group">
                                    <label for="pan_number">Pan Number</label>
                                    <input type="text" class="form-control" id="pan_number" name="pan_number" @if(isset($vendorDetails['pan_number'])) value="{{$vendorDetails['pan_number'] }}" @endif placeholder="Enter Country." required>
                                </div>
                                <div class="form-group">
                                    <label for="address_proof_image">Address Proof Image</label>
                                    <input type="file" class="form-control" id="address_proof_image" name="address_proof_image">
                                    @if(!empty($vendorDetails['address_proof_image']))
                                    <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View Image</a>
                                    <input type="hidden" name="current_address_proof_image" value="{{$vendorDetails['address_proof_image']  }}">
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3"></div> --}}
            </div>
            @elseif($slug=="bank")
            <div class="row">
                {{-- <div class="col-md-3"></div> --}}
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Update Bank Information</h4>
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
                            <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group">
                                    <label for="account_holder_name">Account Holder Name</label>
                                    <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif placeholder="Enter Admin Name" required>

                                </div>
                                <div class="form-group">
                                    <label for="account_number">Account Number</label>
                                    <input type="mobile" class="form-control" id="account_number" name="account_number" @if(isset( $vendorDetails['account_number'] )) value="{{ $vendorDetails['account_number'] }}" @endif placeholder="Enter Mobile No." maxlength="10" minlength="10" required>


                                </div>
                                <div class="form-group">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" @if(isset($vendorDetails['bank_name'] )) value="{{$vendorDetails['bank_name'] }}" @endif placeholder="Enter Address." required>



                                </div>
                                <div class="form-group">
                                    <label for="bank_ifsc_code">Bank_Ifsc_Code</label>
                                    <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code" @if(isset( $vendorDetails['bank_ifsc_code'] )) value="{{$vendorDetails['bank_ifsc_code'] }}" @endif placeholder="Enter City." required>



                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3"></div> --}}
            </div>
            @endif
        </div>


        @include('admin.layout.footer')

        <!-- partial -->
    </div>
    @endsection
