@extends('layouts.app')
@section('description')@parent @stop
@section('keywords')@parent @stop
@section('author')@parent @stop
@section('title')@parent @stop
@section('content')
    @foreach($posts as $post)
        <section class="blog-post">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="blog-post-meta">
                        <a href="{{ route('category.show',$post->category->category_slug) }}"><span
                                    class="label label-light label-primary">{{ $post->category->category_name }}</span></a>
                        @if($post->tags)
                            @foreach($post->tags as $tag)
                                <a href="{{ route('tag.post',$tag->tag_name) }}"><span
                                            class="label label-light label-default">{{ $tag->tag_name }}</span></a>
                            @endforeach
                        @endif
                        <p class="blog-post-date pull-right"><i class="fa fa-clock-o"
                                                                aria-hidden="true"></i>&nbsp;{{ $post->published_at }}
                        </p>
                    </div>
                    <div class="blog-post-content">
                        <a href="{{ route("article.index",$post->post_slug) }}"><h2
                                    class="blog-post-title">{{ $post->post_title }}</h2></a>
                        <p>{{ $post->post_excerpt }}</p>
                        <a class="btn btn-info" href="{{  route("article.index",$post->post_slug) }}">Read more</a>
                    </div>
                </div>
            </div>
        </section><!-- /.blog-post -->
    @endforeach
    {!! $posts->links() !!}
@stop
