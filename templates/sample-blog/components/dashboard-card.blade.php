{{-- Modern Dashboard Card Component --}}
@props(['title', 'value', 'change', 'changeType' => 'positive'])

<div class="dashboard-card">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
        </div>
        @if($change)
            <div class="flex items-center">
                @if($changeType === 'positive')
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm text-green-600 ml-1">{{ $change }}</span>
                @else
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm text-red-600 ml-1">{{ $change }}</span>
                @endif
            </div>
        @endif
    </div>
</div>