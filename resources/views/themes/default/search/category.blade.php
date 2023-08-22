@extends('themes.default.layout')
@section('title'){{ $category->name }} - @parent @endsection
@section('content')
    <div class="bg-light p-3 mb-1">
        <h4>标签：{{ $category->name }}</h4>
    </div>
    <div class="row mt-2 mb-2">
        @foreach($posts as $post)
            <p>
                <span class="fst-italic text-secondary">{{ $post->published_at->format('Y.m.d') }}&nbsp;&nbsp;</span>
                @if($post->type == \App\Constant\PostType::Article->value)
                    <a href="{{ route('articles.show', $post->slug_id) }}" class="text-decoration-none link-secondary">{{ $post->title }}</a>
                @elseif($post->type == \App\Constant\PostType::Tweet->value)
                    <a href="{{ route('tweets.show', $post->slug_id) }}" class="text-decoration-none link-secondary">{{ Str::limit($post->body, 20) }}</a>
                @endif
            </p>
        @endforeach
        {!! $posts->links() !!}
    </div>
@endsection
