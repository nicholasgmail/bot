<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Игры') }}
        </h2>
    </x-slot>
    <livewire:game.new-game />
</x-app-layout>
@push('scripts')

@endpush
