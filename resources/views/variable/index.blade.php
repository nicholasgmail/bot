<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Переменные') }}
        </h2>
    </x-slot>
    <livewire:variable.new-variable />
</x-app-layout>
@push('scripts')

@endpush
