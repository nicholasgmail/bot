<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Категории') }}
        </h2>
    </x-slot>
    <livewire:category.new-category :categories="$categories"/>
</x-app-layout>
@push('scripts')

@endpush
