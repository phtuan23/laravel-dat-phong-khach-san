@extends('layout.client')
@section('content')
 <!-- Blog Details Hero Section Begin -->
 <section class="blog-details-hero set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-details/blog-details-hero.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="bd-hero-text">
                        <h2>{{$blog->name}}</h2>
                        <ul>
                            <li class="b-time"><i class="icon_clock_alt"></i> {{$blog->created_at->format('d-m-Y')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details-text">
                        <div class="bd-title">
                            {!!$blog->content!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr class="w-50">
    <section class="recommend-blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Mới nhất</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($newests as $item)
                <div class="col-md-4">
                    <div class="blog-item set-bg" data-setbg="{{url('public/upload')}}/{{$item->image}}">
                        <div class="bi-text">
                            <h4><a href="{{route('client.blog.detail',$item->id)}}">{{$item->name}}</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> {{$item->created_at->format('d-m-Y')}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@stop()