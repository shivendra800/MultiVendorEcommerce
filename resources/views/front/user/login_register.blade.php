@extends('front.layout.layout')
@section('title', 'User Login/Register')

@section('content')

  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>User Login</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('user/login-register') }}">User Login</a>
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
                    <h2 class="account-h2 u-s-m-b-20">Login</h2>
                    <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                    <p id="login-error"></p>
                    <form id="loginForm" action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="useremail">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" id="users-email" name="email" class="text-field" placeholder="Enter Your Email" >
                            <p id="login-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="userpassword">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="users-password" name="password" class="text-field" placeholder="Enter Your Password" >
                            <p id="login-password"></p>
                        </div>
                        <div class="group-inline u-s-m-b-30">
                            <div class="group-1">
                                <input type="checkbox" class="check-box" id="remember-me-token">
                                <label class="label-text" for="remember-me-token">Remember me</label>
                            </div>
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="{{ url('user/forget-password') }}">
                                        <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Lost your password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Register</h2>
                    <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status and history.</h6>
                    <p id="register-success"></p>
                    <form id="registerForm" action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="username">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user-name" name="name" class="text-field" placeholder="Enter Your Name" >
                            <p id="register-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="usermobile">Mobile
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user-mobile" name="mobile" class="text-field" placeholder="Enter Your Mobile Number" >
                            <p id="register-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="useremail">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" id="user-email" class="text-field" placeholder="Email" >
                            <p id="register-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="userpassword">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password" id="user-password" class="text-field" placeholder="Password" required="">
                            <p id="register-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" name="accept" id="accept" >
                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                            </label>
                            <p id="register-accept"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Register</button>
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
