@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Category</h3>

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
                        <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-categorys') }}" @else action="{{ url('admin/add-edit-categorys/'.$category['id']) }}" @endif method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" name="category_name" id="category_name"@if(!empty($category['category_name']))
                                 value="{{ $category['category_name'] }}"  @else value="{{ old('category_name') }}" @endif
                                 placeholder="Enter category Name" required>

                            </div>
                            <div class="form-group">
                                <label for="section_id">Section</label>
                                <select class="form-control" id="section_id" name="section_id" style="color:#000;">
                                    <option>Select Section</option>
                                    @foreach ($getSections as $section )
                                    <option value="{{ $section['id']}}"  @if(!empty($category['section_id'])&& $category['section_id']==$section['id']) selected="" @endif>
                                        {{ $section['name'] }}</option>

                                    @endforeach

                                </select>
                            </div>

                            <div id="appendCategoriesLevel">
                                    @include('admin.categorys.append_categories_level')
                            </div>
                            <div class="form-group">
                                <label for="category_image">Category Photo</label>
                                <input type="file" class="form-control" id="category_image" name="category_image">
                                @if(!empty($category->category_image))
                                <a target="_blank" href="{{ url('front/images/category_image/'.$category->category_image) }}">View Image</a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" class="confirmDelete" module="category-image" moduleid="{{ $category['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excle-box"></i>Delete Image</a>
                                <input type="hidden" name="current_category_image" value="{{$category->category_image  }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="category_discount">Discount</label>
                                <input type="text" class="form-control" name="category_discount" id="category_discount"@if(!empty($category['category_discount']))
                                 value="{{ $category['category_discount'] }}"  @else value="{{ old('category_discount') }}" @endif
                                 placeholder="Enter category discount">

                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="text" class="form-control" name="url" id="url"@if(!empty($category['url']))
                                value="{{ $category['url'] }}"  @else value="{{ old('url') }}" @endif
                                placeholder="Enter url" required>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Meta_Title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title"@if(!empty($category['meta_title']))
                                value="{{ $category['meta_title'] }}"  @else value="{{ old('meta_title') }}" @endif
                                placeholder="Enter meta_title" required>

                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta_Description</label>
                                <input type="text" class="form-control" name="meta_description" id="meta_description"@if(!empty($category['meta_description']))
                                value="{{ $category['meta_description'] }}"  @else value="{{ old('meta_description') }}" @endif
                                placeholder="Enter meta_description" required>

                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta_Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"@if(!empty($category['meta_keywords']))
                                value="{{ $category['meta_keywords'] }}"  @else value="{{ old('meta_keywords') }}" @endif
                                placeholder="Enter meta_keywords" required>


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
