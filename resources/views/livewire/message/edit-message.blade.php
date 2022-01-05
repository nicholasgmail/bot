<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
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
                    <form wire:submit.prevent="save">
                        <div class="flex flex-row flex-wrap flex-auto flex-1 gap-6">
                            <div class="w-full md:w-5/12">
                                <div class="inline-block pt-2 mb-4">
                                    <label for="title">Заголовок</label>
                                    <input wire:model="title" id="title" name="title" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    @if($errors->has('title'))
                                        @error('title') <p class="error ">{{ $message }}</p> @enderror
                                    @endif
                                </div>
                                <textarea wire:model="caption" rows="9" class="{{$classes}}"
                                          placeholder="Послание"></textarea>
                                @if($errors->has('caption'))
                                    @error('caption') <p class="error">{{ $message }}</p> @enderror
                                @else
                                    <p>Измени запись</p>
                                @endif
                            </div>
                            <livewire:components.option.using-condition :message="$message" :classes="$classes"/>
                        </div>
                        <div class="flex flex-row flex-auto">
                            <div class="w-full md:w-5/12">
                                <div class="inline-block pt-2">
                                    <label for="priority">Номер порядковый</label>
                                    <input wire:model="priority" id="priority" name="priority" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                           placeholder="1" value="1">
                                </div>
                                <div class="flex flex-row flex-auto items-stretch py-4">
                                    <div class="inline-block pr-3">
                                        <select wire:model="delay_type" id="delayType"
                                                class="form-select text-black sm:text-sm">
                                            <option selected value="seconds">секунды</option>
                                            <option value="minutes">минута</option>
                                            <option value="hours">час</option>
                                            <option value="days">день</option>
                                        </select>
                                    </div>
                                    <div class="inline-block">
                                        <input wire:model="delay" name="delay" type="text" required
                                               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                               placeholder="15">
                                    </div>
                                </div>
                                <div class="block pt-2">
                                    <div class="pt-1" style="text-align: start;">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="following"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{__('Скрыть кнопки')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="block pt-2">
                                    <div class="pt-1" style="text-align: start;">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="expect"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{__('Ожидать ответ')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="block pt-2">
                                    <div class="pt-1" style="text-align: start;">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="pad"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{__('Прокладка')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="flex-1 w-12/12 md:w-6/12 ml-4">
                                <div class="mt-3">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="button_type" checked value="inline"
                                               name="variant"
                                               class="form-checkbox h-6 w-6 text-green-500">
                                        <span class="ml-3 text-sm">Инлайн</span>
                                    </label>
                                </div>
                                <div class="mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="button_type" value="reply" name="reply"
                                               class="form-checkbox h-6 w-6 text-green-500">
                                        <span class="ml-3 text-sm">Реплика</span>
                                    </label>
                                </div>
                            </div>--}}
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 mb-3 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Сохранить
                            </button>
                            <button type="button"
                                    wire:click="addDummy"
                                    class="py-2 px-4 ml-4 mb-3 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Создать кнопку
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
                        <div class="shadow overflow-hidden bg-white p-4">
                            @if($message->transitions->isNotEmpty())
                                @foreach($message->transitions as $key=>$transition)
                                    @if($transition)
                                        <livewire:components.transiton :transition="$transition" :key="$key"/>
                                    @endif
                                @endforeach
                            @else
                                {{ __('Диалогов нет в контексте‼ 👆') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isOpenWhere)
        <x-modal.info wire:model="isOpenWhere" maxWidth="2xl">
            <x-slot name="title">
                Настройки кнопки
            </x-slot>
            <x-slot name="svg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                     fill="rgba(59, 130, 246, 0.5)">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                </svg>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-col md:flex-row flex-wrap gap-6 p-4">
                    <div class="flex-1">
                        <div class="flex flex-row flex-wrap">
                            @foreach($option_transitions as $key=>$option)
                                <livewire:components.form.radio :context="$context_type" :option="$option"
                                                                :value="$key"
                                                                :key="$key"/>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1">
                        <input wire:model="search" class="w-full rounded p-2" type="text" placeholder="Поиск...">
                    </div>
                </div>
                <div class="overflow-hidden">
                    <div class="overflow-y-scroll h-96">
                        @if($context_type == 'messages')
                            <livewire:components.tables.table-messages :messages="$all_messages"/>
                        @else
                            <livewire:components.tables.table-storylines :storylines="$all_storylines"/>
                        @endif
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('isOpenWhere')">
                    Закрыть
                </x-jet-secondary-button>
            </x-slot>
        </x-modal.info>
    @endif
</div>
