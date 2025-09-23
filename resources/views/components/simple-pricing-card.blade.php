@props([
    'title',
    'price',
    'features' => [],
    'buttonText' => 'Souscrire',
    'buttonUrl' => '#',
    'isPopular' => false,
    'period' => null
])

<div class="relative">
    @if($isPopular)
        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-10">
            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                Populaire
            </span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 h-full flex flex-col
                @if($isPopular) border-2 border-orange-200 @else border border-gray-200 @endif">

        <div class="text-center mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <div class="flex items-baseline justify-center">
                <span class="text-3xl font-bold text-orange-600">{{ $price }}</span>
                @if($period)
                    <span class="text-gray-500 ml-1">{{ $period }}</span>
                @endif
            </div>
        </div>

        <ul class="space-y-3 flex-grow mb-6">
            @foreach($features as $feature)
                <li class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $feature }}
                </li>
            @endforeach
        </ul>

        <a href="{{ $buttonUrl }}"
           class="@if($isPopular) bg-orange-600 hover:bg-orange-700 text-white @else bg-gray-100 hover:bg-gray-200 text-gray-900 @endif
                  w-full py-3 px-4 rounded-lg font-medium transition-colors duration-200 text-center">
            {{ $buttonText }}
        </a>
    </div>
</div>
