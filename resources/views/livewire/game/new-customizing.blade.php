<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12" {{--@notify="alert('Сохранено')"--}}>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 relative" x-data="{ open: @entangle('open') }">
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90">
                    @if (session()->has('message'))
                        <div class="bg-green-30 p-6 border border-gray-300 bg-rose-100">
                            {{ session('message') }}
                        </div>
                    @endif
                    <button class="absolute top-0 right-0 p-4" wire:click="close">X</button>
                </div>
            </div>
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit.prevent="saveGame">
                        <div class="flex flex-row flex-auto gap-6">

                            <livewire:components.game.n-shell :game="$game"/>
                            <div class="flex-1">
                                <div class="inline-block pt-2 w-full sm:w-auto">
                                    <label for="title">Заголовок</label>
                                    <input wire:model="name" id="title" name="title" type="text"
                                           class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <div class="mt-1 mb-2">
                                    @if($errors->has('name'))
                                        @error('name') <p class="error ">{{ $message }}</p> @enderror
                                    @endif
                                </div>
                                <br>
                                <p>Список кодов для игры</p>
                                <div class="flex flex-col flex-wrap gap-4 pt-2 sm:flex-row mb-4 w-full sm:w-4/5">
                                    <div class="flex-1">
                                        <label for="first_train"></label>
                                        <input wire:model.defer.lazy="first_train" id="first_train" name="first_train"
                                               type="text"
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        @if($errors->has('first_train'))
                                            @error('first_train') <p class="error">{{ $message }}</p> @enderror
                                        @else
                                            <p>Первая треня</p>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <label for="regular_train"></label>
                                        <input wire:model.defer.lazy="regular_train" id="regular_train"
                                               name="regular_train"
                                               type="text"
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        @if($errors->has('regular_train'))
                                            @error('regular_train') <p class="error">{{ $message }}</p> @enderror
                                        @else
                                            <p>Обычная треня</p>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <label for="raid"></label>
                                        <input wire:model.defer.lazy="raid" id="raid" name="raid" type="text"
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        @if($errors->has('raid'))
                                            @error('raid') <p class="error">{{ $message }}</p> @enderror
                                        @else
                                            <p>Рейд</p>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <label for="battle"></label>
                                        <input wire:model.defer.lazy="battle" id="battle" name="battle" type="text"
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                        @if($errors->has('battle'))
                                            @error('battle') <p class="error">{{ $message }}</p> @enderror
                                        @else
                                            <p>Батл</p>
                                        @endif
                                    </div>
                                </div>
                                {{--tabs--}}
                                {{--<livewire:components.tabs.game-page.random-tabs :game="$game"/>--}}
                                <div class="flex flex-row flex-auto items-stretch py-4">
                                    <div class="inline-block w-full sm:w-auto">
                                        <label for="field_size">Размер поля</label>
                                        <input wire:model.lazy="field_size" id="field_size" type="text" required
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                               placeholder="15">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4 ">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg p-4 relative">
                            <div class="flex flex-row flex-wrap">
                                @for($cell; $cell <= $field_size; $cell++)
                                    <div class="flex-auto p-2" style="min-width: 25%">
                                        <livewire:game.cell :cell="$cell" :game="$game" :key="$cell"/>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
