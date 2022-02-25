@extends('layout.client')
@section('content')
    <style>
        #title_blog:hover {
            background-color: #f5cb98;
            color : #fff;
            padding : 5px
        }
    </style>
 <!-- Breadcrumb Section Begin -->
 <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Blog</h2>
                        <div class="bt-option">
                            <a href="./home.html">Home</a>
                            <span>Blog Grid</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    
    <!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-md-6">
                    <div class="blog-item set-bg" data-setbg="{{url('public/upload')}}/{{$blog->image}}">
                        <div class="bi-text">
                            <h4  class="font-weight-bold"><a href="{{route('client.blog.detail',$blog->id)}}" style="color:#edecc5;" id="title_blog">{{$blog->name}}</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> {{$blog->created_at}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-md-12">
                <div class="text-center m-auto">
                    {{$blogs->links()}}
                </div>
            </div>
        </div>
    </section>
@stop()