@extends('front.layout.layout')
@section('title', 'About Us')

@section('content')

  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>About</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="about.html">About</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- About-Page -->
<div class="page-about u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="about-me-info u-s-m-b-30">
                    <h1>Welcome to
                        <span>Shivendra Developers</span>
                    </h1>
                    <p>
                        {{ $cmsPageDetails['description'] }}
                    </p>
                 
                </div>
            </div>
            {{-- <div class="col-lg-6 col-md-12">
                <div class="about-me-image u-s-m-b-30">
                    <div class="banner-hover effect-border-scaling-gray">
                        <a href="https://www.youtube.com/StackDevelopers"><img class="img-fluid" src="images/about/about-1.jpg" alt="About Picture"></a>
                    </div>
                </div>
                <div class="about-social text-center u-s-m-b-30">
                    <ul class="social-media-list">
                        <li>
                            <a href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-rss"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- About-Page /- -->
@endsection