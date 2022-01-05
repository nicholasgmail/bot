<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Редактирование сообщение ') }}
                    </h2>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-menu.n-link href="{{ route('storyline_edit', $video->storyline->first()->id) }}" class="text-cyan-900 hover:text-gray-800 opacity-75">
                        {{ __('Вернуться ↩️') }}
                    </x-menu.n-link>
                </div>
            </div>
        </div>
    </x-slot>
    <livewire:video.edit-video :video="$video"/>
</x-app-layout>
@push('scripts')

@endpush
