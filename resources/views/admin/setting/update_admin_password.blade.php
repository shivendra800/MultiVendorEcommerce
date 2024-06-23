@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Setting</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Update Admin Password</h4>
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
                        <form class="forms-sample" action="{{ url('admin/update-admin-password') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Admin Username/Email</label>
                                <input class="form-control" value="{{ $adminDetails['email'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Admin Type</label>
                                <input class="form-control" value="{{ $adminDetails['type'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="current_password">Old Password</label>
                                <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Current Password" required>
                                <span id="check_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_pasword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_pasword" name="confirm_pasword" placeholder="Confirm Password" required>
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
