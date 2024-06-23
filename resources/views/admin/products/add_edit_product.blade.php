@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Product</h3>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">{{ $title }}</h4>
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
                        <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="form-group">
                                <label for="category_id">Select category</label>
                                <select class="form-control text-dark" id="category_id" name="category_id" style="color:#000;" required>
                                    <option>Select section</option>
                                    @foreach ($categories as $section )
                                    <optgroup label="{{ $section['name']}}"></optgroup>
                                    @foreach ($section['categories'] as $category)
                                    <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif value={{ $category['id'] }}>&nbsp;&nbsp;&nbsp;---&nbsp;{{ $category['category_name'] }}</option>
                                    @foreach ($category['subcategories'] as $subcategory)
                                    <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value={{ $subcategory['id'] }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="loadFilters">
                                @include('admin.filters.category_filters')
                            </div>
                            <div class="form-group">
                                <label for="brand_id">Select Brand</label>
                                <select class="form-control text-dark" id="brand_id" name="brand_id">
                                    <option>Select brand</option>
                                    @foreach ($brands as $brand )
                                    <option @if(!empty($product['brand_id']==$brand['id'])) selected="" @endif value="{{ $brand['id']}}" @if(!empty($brand['brand_id'])&& $brand['brand_id']==$brand['id']) selected="" @endif>
                                        {{ $brand['name'] }}</option>

                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif placeholder="Enter Product Name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" name="product_code" id="product_code" @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ old('product_code') }}" @endif placeholder="Enter Product Code" required>
                            </div>
                            <div class="form-group">
                                <label for="product_color">Product Color</label>
                                <input type="text" class="form-control" name="product_color" id="product_color" @if(!empty($product['product_color'])) value="{{ $product['product_color'] }}" @else value="{{ old('product_color') }}" @endif placeholder="Enter Product Color" required>
                            </div>
                            <div class="form-group">
                                <label for="group_code">Group Code</label>
                                <input type="text" class="form-control" name="group_code" id="group_code" @if(!empty($product['group_code'])) value="{{ $product['group_code'] }}" @else value="{{ old('group_code') }}" @endif placeholder="Enter Group Code" >
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price </label>
                                <input type="number" class="form-control" name="product_price" id="product_price" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif placeholder="Enter Product Price " required>
                            </div>
                            <div class="form-group">
                                <label for="product_discount">Product Discount(%) </label>
                                <input type="text" class="form-control" name="product_discount" id="product_discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('product_weight') }}" @endif placeholder="Enter Product Weight" </div>
                                <div class="form-group">
                                    <label for="product_weight">Product Weight </label>
                                    <input type="text" class="form-control" name="product_weight" id="product_weight" @if(!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif placeholder="Enter Product Weight">
                                </div>
                                <div class="form-group">
                                    <label for="product_image">Product Image (Recommended Size: 1000x1000)</label>
                                    <input type="file" class="form-control" id="product_image" name="product_image">
                                    @if(!empty($product->product_image))
                                    <a target="_blank" href="{{ url('front/images/product_image/large/'.$product->product_image) }}">View Image</a>&nbsp;&nbsp;
                                    <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excle-box"></i>Delete Image</a>
                                    <input type="hidden" name="current_product_image" value="{{$product->product_image  }}">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="product_video">Product Video (Recommended Less then 2MB)</label>
                                    <input type="file" class="form-control" id="product_video" name="product_video">
                                    @if(!empty($product->product_video))
                                    <a target="_blank" href="{{ url('front/videos/product_video/'.$product->product_video) }}">View video</a>&nbsp;&nbsp;
                                    <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excle-box"></i>Delete video</a>
                                    <input type="hidden" name="current_product_video" value="{{$product->product_video  }}">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{$product->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Meta_Title</label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif placeholder="Enter meta_title" required>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta_Description</label>
                                    <input type="text" class="form-control" name="meta_description" id="meta_description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif placeholder="Enter meta_description" required>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta_Keywords</label>
                                    <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif placeholder="Enter meta_keywords" required>
                                </div>
                                <div class="form-group">
                                    <label for="is_featured">Featured Items</label>
                                    <input type="checkbox" class="form-control" name="is_featured" id="is_featured" value="Yes" @if(!empty($product['is_featured'])&& $product['is_featured']=="Yes" ) checked="" @endif placeholder="Enter is_featured">
                                </div>
                                <div class="form-group">
                                    <label for="is_bestseller">Best Seller Item</label>
                                    <input type="checkbox" class="form-control" name="is_bestseller" id="is_bestseller" value="Yes" @if(!empty($product['is_bestseller'])&& $product['is_bestseller']=="Yes" ) checked="" @endif placeholder="Enter is_bestseller">
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
