{{-- Badge Showcase Component --}}
@props(['user'])

@php
    $badgeService = app(\App\Services\BadgeService::class);
    $earnedBadges = $badgeService->getUserBadges($user);
    $availableBadges = $badgeService->getAvailableBadges($user);
    $progress = $badgeService->getBadgeProgress($user);
@endphp

<div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-700 rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Badges & Achievements') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $progress['earned_badges'] }} {{ __('of') }} {{ $progress['total_badges'] }} {{ __('badges earned') }}</p>
        </div>
        <div class="text-right">
            <p class="text-3xl font-bold text-teal-600 dark:text-teal-400">{{ $progress['total_points'] }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Points') }}</p>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Progress') }}</span>
            <span class="text-sm font-semibold text-teal-600 dark:text-teal-400">{{ $progress['progress_percentage'] }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 h-3 rounded-full transition-all duration-500" style="width: {{ $progress['progress_percentage'] }}%"></div>
        </div>
    </div>

    {{-- Earned Badges --}}
    @if($earnedBadges->count() > 0)
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('Earned Badges') }}</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($earnedBadges as $badge)
                    <div class="group relative">
                        <div class="bg-gradient-to-br from-{{ $badge->color }}-50 to-{{ $badge->color }}-100 border-2 border-{{ $badge->color }}-300 dark:from-{{ $badge->color }}-900/40 dark:to-{{ $badge->color }}-800/40 dark:border-{{ $badge->color }}-700/50 rounded-xl p-4 text-center hover:scale-105 transition-transform cursor-pointer">
                            <div class="text-4xl mb-2">{{ $badge->icon }}</div>
                            <p class="font-semibold text-gray-800 dark:text-white text-sm">{{ $badge->name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $badge->points }} pts</p>
                            <span class="inline-block mt-2 px-2 py-1 bg-{{ $badge->color }}-200 dark:bg-{{ $badge->color }}-900/50 text-{{ $badge->color }}-800 dark:text-{{ $badge->color }}-300 text-xs font-semibold rounded-full">
                                {{ ucfirst($badge->type) }}
                            </span>
                        </div>
                        {{-- Tooltip --}}
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 dark:bg-black text-white text-xs rounded-lg py-2 px-3 max-w-xs shadow-lg">
                                {{ $badge->description }}
                                <div class="text-gray-400 mt-1">
                                    {{ __('Earned') }}: {{ \Carbon\Carbon::parse($badge->pivot->earned_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Available Badges (Locked) --}}
    @if($availableBadges->count() > 0)
        <div>
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('Locked Badges') }}</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($availableBadges->take(8) as $badge)
                    <div class="group relative">
                        <div class="bg-gray-100 dark:bg-gray-700/50 border-2 border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center opacity-60 hover:opacity-80 transition-opacity cursor-pointer">
                            <div class="text-4xl mb-2 grayscale">{{ $badge->icon }}</div>
                            <p class="font-semibold text-gray-600 dark:text-gray-400 text-sm">{{ $badge->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $badge->points }} pts</p>
                            <span class="inline-block mt-2 px-2 py-1 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-full">
                                🔒 {{ __('Locked') }}
                            </span>
                        </div>
                        {{-- Tooltip --}}
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 dark:bg-black text-white text-xs rounded-lg py-2 px-3 max-w-xs shadow-lg">
                                {{ $badge->description }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
