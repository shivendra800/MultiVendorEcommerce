@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Section</h4>
                        <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/add-edit-section') }}" class="btn btn-block btn-primary">Add Section</a>
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

                        <div class="table-responsive pt-3">
                            <table id="sections" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section )


                                    <tr>
                                        <td>
                                            {{ $section['id'] }}
                                        </td>
                                        <td>
                                            {{ $section['name'] }}
                                        </td>



                                        <td>
                                            @if($section['status']==1)
                                            <a class="updateSectionStatus" id="section-{{ $section['id'] }}" section_id="{{ $section['id'] }}" href="javascript:void(0)">
                                                <i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>

                                            @else
                                            <a class="updateSectionStatus" id="section-{{ $section['id'] }}" section_id="{{ $section['id'] }}" href="javascript:void(0)">
                                                <i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                        <td>

                                            <a title="Edit Section Details" href="{{ url('admin/add-edit-section/'.$section['id'] ) }}" <i style="font-size:25px;" class="mdi mdi-pencil"></i></a>
                                            {{-- <a title="section" class="confirmDelete"  href="{{ url('admin/delete-section/'.$section['id'] ) }}" ><i style="font-size:25px;" class="mdi mdi-file-excle-box"></i>d</a> --}}
                                            <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" module="section" moduleid="{{ $section['id'] }}"><i style="font-size:25px;" class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap section template</a> from BootstrapDash. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    {{-- @include('admin.layout.footer')

<!-- partial -->
</div> --}}
    @endsection
