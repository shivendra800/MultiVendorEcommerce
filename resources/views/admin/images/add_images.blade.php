@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold"> Images</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Images</h4>
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
                        <form class="forms-sample" action="{{ url('admin/add-images/'.$product['id']) }}" method="post" enctype="multipart/form-data">
                            @csrf




                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                &nbsp;{{ $product['product_name'] }}
                            </div>
                            <div class="form-group">
                                <label for="product_code">Product code</label>
                                &nbsp;{{ $product['product_code'] }}
                            </div>
                            <div class="form-group">
                                <label for="product_color">Product Color</label>
                                &nbsp;{{ $product['product_color'] }}
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price</label>
                                &nbsp;{{ $product['product_price'] }}
                            </div>
                            <div class="form-group">
                                @if(!empty($product['product_image']))
                                <img style="width: 120px;" src="{{ url('front/images/product_image/large/'.$product['product_image']) }}">
                                @else
                                <img style="width: 120px;" src="{{ url('front/images/product_image/small/no-image.png') }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="field_wrapper">

                                    <input type="file" name="images[]" multiple="" id="images">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                        <br>
                        <h4 class="card-title">Add Images</h4>

                        <table id="sections" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product['images'] as $image)
                                <tr>
                                    <td>{{ $image['id'] }}</td>
                                    <td>
                                        <img style="width: 60px; height:60px;" src=" {{ asset('front/images/product_image/small/'.$image['image']) }}" </td>
                                    <td>
                                        @if($image['status']==1)
                                        <a class="updateimagesStatus" id="image-{{ $image['id'] }}" product_id="{{ $image['id'] }}" href="javascript:void(0)">
                                            <i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>

                                        @else

                                        <a class="updateimagesStatus" id="image-{{ $image['id'] }}" product_id="{{ $image['id'] }}" href="javascript:void(0)">
                                            <i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>

                                        @endif
                                    </td>
                                    <td>
                                        <a title="Delete Product Image" href="javascript:void(0)" class="confirmDelete" module="image" moduleid="{{ $image['id'] }}"><i style="font-size:25px;" class="mdi mdi-delete"></i></a>
                                    </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
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
