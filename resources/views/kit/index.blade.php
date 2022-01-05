<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Наборы') }}
        </h2>
    </x-slot>
   <livewire:kits.index />
</x-app-layout>
@push('scripts')

@endpush
