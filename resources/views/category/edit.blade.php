<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Категория') . "`" . $category->name . "`" }}
                    </h2>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-menu.n-link href="{{ route('categories') }}" class="text-cyan-900 hover:text-gray-800 opacity-75">
                        {{ __('Перейти к категориям') }}
                    </x-menu.n-link>
                </div>
            </div>
        </div>
    </x-slot>
    <livewire:category.edit-customizing  :category="$category"/>
</x-app-layout>
@push('scripts')

@endpush
