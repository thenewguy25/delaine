{{-- Startup NextJS Template Template Component --}}
@props(['title', 'content'])

<div class="template-card">
    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    <div class="text-gray-600">{{ $content }}</div>
</div>
