<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Редактирование сообщение с картинкой') }}
                    </h2>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if($type == 'storyline')
                        <x-menu.n-link href="{{ route('storyline_edit', $image->storyline->first()->id) }}"
                                       class="text-cyan-900 hover:text-gray-800 opacity-75">
                            {{ __('Вернуться ↩️') }}
                        </x-menu.n-link>
                    @elseif($type == 'game')
                        <x-menu.n-link href="{{ route('games') }}" class="text-cyan-900 hover:text-gray-800 opacity-75">
                            {{ __('Возвратится к списку игр') }}
                        </x-menu.n-link>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
    @if($type == 'storyline')
        <livewire:image.edit-image :image="$image" :type="$type"/>
    @elseif($type == 'game')
        <livewire:image.edit-game-image :image="$image" :type="$type"/>
    @elseif( $type == 'dice')
        <livewire:image.edit-dice :image="$image" :type="$type"/>
    @endif
</x-app-layout>
@push('scripts')

@endpush
