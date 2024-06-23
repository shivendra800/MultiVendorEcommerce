@extends('front.layout.layout')

@section('title', 'My Account ')

@section('content')

  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>User Account Details Form</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('user/login-register') }}">User Account Details Form</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Errors:</strong> {{Session::get('error_message')}}
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
        @if($errors->any(''))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> <?php echo implode('',$errors->all('<div>:message</div>')); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">

            <!-- Login -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Update Account Details</h2>
                    <p id="account-error"></p>
                    <p id="account-success"></p>
                    <form id="accountForm" action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="useremail">Email
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" value="{{ Auth::user()->email }}" style="background-color: #e9e9;" readonly>
                            <p id="account-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="username">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text"  class="text-field" id="user-name" name="name" value="{{ Auth::user()->name }}" >
                            <p id="account-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="usermobile">Mobile No
                                <span class="astk">*</span>
                            </label>
                            <input type="number"  class="text-field" id="user-mobile" name="mobile" value="{{ Auth::user()->mobile }}" >
                            <p id="account-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="useraddress">Address
                                <span class="astk">*</span>
                            </label>
                            <input type="text"  class="text-field" id="user-address" name="address" value="{{ Auth::user()->address }}" >
                            <p id="account-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-country"> Country</label>
                            <select class="text-field" id="user-country" name="country">
                                <option>Select Country</option>
                                @foreach ($countries as $country )
                                <option value="{{ $country['country_name']}}" @if($country['country_name']==Auth::user()->country) selected @endif>
                                    {{ $country['country_name'] }}</option>

                                @endforeach

                            </select>
                            <p id="account-country"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="userstates">States
                                <span class="astk">*</span>
                            </label>
                            <input type="text"  class="text-field" id="user-states" name="state" value="{{ Auth::user()->state }}" >
                            <p id="account-state"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="usercity">City
                                <span class="astk">*</span>
                            </label>
                            <input type="text"  class="text-field" id="user-city" name="city" value="{{ Auth::user()->city }}" >
                            <p id="account-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="userpincode">Pincode
                                <span class="astk">*</span>
                            </label>
                            <input type="text"  class="text-field" id="user-pincode" name="pincode" value="{{ Auth::user()->pincode }}" >
                            <p id="account-pincode"></p>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Update Contact Details /- -->
            <!-- Update Password -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Update Password</h2>
                    <p id="password-success"></p>
                    <p id="password-error"></p>
                    <form id="passwordForm" action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="current-password">Current Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="current_password" id="current-password" class="text-field" placeholder="current-password" required="">
                            <p id="password-current-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="new-password">New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="new_password" id="new-password" class="text-field" placeholder="new-password" required="">
                            <p id="password-new-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="confirm-password">Confirm New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="confirm_password" id="confirm-password" class="text-field" placeholder="confirm-password" required="">
                            <p id="password-confirm-password"></p>
                        </div>

                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->

@endsection
