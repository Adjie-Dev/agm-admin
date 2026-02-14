@props([
    'type' => 'info',
    'message' => '',
    'title' => '',
    'autoClose' => true,
    'duration' => 5000
])

@php
    $config = match($type) {
        'success' => [
            'iconBg' => 'bg-green-500/10',
            'iconColor' => 'text-green-500',
            'titleColor' => 'text-green-400',
            'border' => 'border-green-500/30',
            'progressBg' => 'bg-green-500',
            'defaultTitle' => 'Berhasil!',
            'icon' => 'M5 13l4 4L19 7'
        ],
        'error' => [
            'iconBg' => 'bg-red-500/10',
            'iconColor' => 'text-red-500',
            'titleColor' => 'text-red-400',
            'border' => 'border-red-500/30',
            'progressBg' => 'bg-red-500',
            'defaultTitle' => 'Error!',
            'icon' => 'M6 18L18 6M6 6l12 12'
        ],
        'warning' => [
            'iconBg' => 'bg-yellow-500/10',
            'iconColor' => 'text-yellow-500',
            'titleColor' => 'text-yellow-400',
            'border' => 'border-yellow-500/30',
            'progressBg' => 'bg-yellow-500',
            'defaultTitle' => 'Peringatan!',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
        ],
        'info' => [
            'iconBg' => 'bg-blue-500/10',
            'iconColor' => 'text-blue-500',
            'titleColor' => 'text-blue-400',
            'border' => 'border-blue-500/30',
            'progressBg' => 'bg-blue-500',
            'defaultTitle' => 'Informasi',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        ],
        default => [
            'iconBg' => 'bg-gray-500/10',
            'iconColor' => 'text-gray-500',
            'titleColor' => 'text-gray-400',
            'border' => 'border-gray-500/30',
            'progressBg' => 'bg-gray-500',
            'defaultTitle' => 'Notifikasi',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        ]
    };

    $displayTitle = $title ?: $config['defaultTitle'];
@endphp

<div x-data="{
        show: true,
        progress: 100,
        autoClose: {{ $autoClose ? 'true' : 'false' }},
        duration: {{ $duration }},
        interval: null,

        init() {
            if (this.autoClose) {
                this.startProgress();
            }
        },

        startProgress() {
            const step = 100 / (this.duration / 100);
            this.interval = setInterval(() => {
                this.progress -= step;
                if (this.progress <= 0) {
                    this.close();
                }
            }, 100);
        },

        close() {
            if (this.interval) {
                clearInterval(this.interval);
            }
            this.show = false;
        },

        pauseProgress() {
            if (this.interval && this.autoClose) {
                clearInterval(this.interval);
            }
        },

        resumeProgress() {
            if (this.autoClose && this.progress > 0) {
                this.startProgress();
            }
        }
     }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     @mouseenter="pauseProgress()"
     @mouseleave="resumeProgress()"
     class="fixed top-4 right-4 z-50 w-full max-w-md">

    <div class="bg-slate-800/95 backdrop-blur-xl rounded-2xl border {{ $config['border'] }} shadow-2xl overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <!-- Icon -->
                <div class="flex-shrink-0 w-12 h-12 rounded-full {{ $config['iconBg'] }} flex items-center justify-center">
                    @if($type === 'success')
                        <svg class="w-6 h-6 {{ $config['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                        </svg>
                    @elseif($type === 'error')
                        <svg class="w-6 h-6 {{ $config['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 {{ $config['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                        </svg>
                    @endif
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold {{ $config['titleColor'] }} mb-1">
                        {{ $displayTitle }}
                    </h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ $message }}
                    </p>
                </div>

                <!-- Close Button -->
                <button @click="close()"
                        class="flex-shrink-0 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Progress Bar -->
        @if($autoClose)
            <div class="h-1 bg-slate-700/50">
                <div class="{{ $config['progressBg'] }} h-full transition-all duration-100 ease-linear"
                     :style="'width: ' + progress + '%'"></div>
            </div>
        @endif
    </div>
</div>
