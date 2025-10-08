@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Blog Posts</h1>
    
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as $post)
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
            @endif
            
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>{{ $post->category->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                </div>
                
                <h2 class="text-xl font-semibold mb-3">
                    <a href="{{ route('blog.posts.show', $post) }}" class="hover:text-blue-600">
                        {{ $post->title }}
                    </a>
                </h2>
                
                <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                
                <a href="{{ route('blog.posts.show', $post) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Read More →
                </a>
            </div>
        </article>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection
