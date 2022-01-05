<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Кости наборы') }}
        </h2>
    </x-slot>
    <livewire:dice.add-new/>
</x-app-layout>
@push('scripts')

@endpush
