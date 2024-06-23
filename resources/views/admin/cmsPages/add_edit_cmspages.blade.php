@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Cms Page</h3>

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
                        <form class="forms-sample" @if(empty($CmsPage['id'])) action="{{ url('admin/add-edit-cmspages') }}"
                            @else action="{{ url('admin/add-edit-cmspages/'.$CmsPage['id']) }}"   @endif
                         method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title"@if(!empty($CmsPage['title']))
                                 value="{{ $CmsPage['title'] }}"  @else value="{{ old('title') }}" @endif
                                 placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $CmsPage['description'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="text" class="form-control" name="url" id="url"@if(!empty($CmsPage['url']))
                                value="{{ $CmsPage['url'] }}"  @else value="{{ old('url') }}" @endif
                                placeholder="Enter url" required>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Meta_Title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title"@if(!empty($CmsPage['meta_title']))
                                value="{{ $CmsPage['meta_title'] }}"  @else value="{{ old('meta_title') }}" @endif
                                placeholder="Enter meta_title" required>

                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta_Description</label>
                                <input type="text" class="form-control" name="meta_description" id="meta_description"@if(!empty($CmsPage['meta_description']))
                                value="{{ $CmsPage['meta_description'] }}"  @else value="{{ old('meta_description') }}" @endif
                                placeholder="Enter meta_description" required>

                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Meta_Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"@if(!empty($CmsPage['meta_keywords']))
                                value="{{ $CmsPage['meta_keywords'] }}"  @else value="{{ old('meta_keywords') }}" @endif
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
