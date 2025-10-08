@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        <header class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span>{{ $post->category->name }}</span>
                <span class="mx-2">•</span>
                <span>{{ $post->published_at->format('M d, Y') }}</span>
                <span class="mx-2">•</span>
                <span>By {{ $post->author->name }}</span>
            </div>
            
            <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
            
            @if($post->excerpt)
            <p class="text-xl text-gray-600">{{ $post->excerpt }}</p>
            @endif
        </header>
        
        @if($post->featured_image)
        <div class="mb-8">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full rounded-lg">
        </div>
        @endif
        
        <div class="prose prose-lg max-w-none">
            {!! $post->content !!}
        </div>
        
        <div class="mt-8 pt-8 border-t">
            <a href="{{ route('blog.posts.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Back to Blog
            </a>
        </div>
    </article>
</div>
@endsection
