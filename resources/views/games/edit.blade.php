<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Игра ') . "`" . $game->name . "`" }}
                    </h2>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-menu.n-link href="{{ route('games') }}" class="text-cyan-900 hover:text-gray-800 opacity-75">
                        {{ __('Перейти к списку игр') }}
                    </x-menu.n-link>
                </div>
            </div>
        </div>
    </x-slot>
    <livewire:game.new-customizing :idGame="$game->id" :game="$game"/>
</x-app-layout>
@push('scripts')

@endpush
