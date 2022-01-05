<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Сюжет') }}
        </h2>
    </x-slot>
    <livewire:storyline.new-storyline />
</x-app-layout>
@push('scripts')

@endpush
