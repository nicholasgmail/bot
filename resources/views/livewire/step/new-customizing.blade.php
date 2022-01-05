<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit.prevent="addContent" enctype="multipart/form-data">
                        <div class="flex flex-row flex-auto gap-6">
                            <div class="flex-1">
                                <div class="inline-block pt-2 mb-4">
                                    <label for="title">Заголовок</label>
                                    <input wire:model="title" id="title" name="title" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <textarea wire:model="text" rows="9" class="{{$classes}}"
                                          placeholder="Послание"></textarea>
                                @if($errors->isNotEmpty())
                                    @error('text') <p class="error">{{ $message }}</p> @enderror
                                @else
                                    <p>Сделай запись</p>
                                @endif
                                <div class="flex flex-row flex-auto items-stretch py-4">
                                    <div class="inline-block pr-3">
                                        <select wire:model="delay_type" id="inputState"
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

                            </div>
                            <div class="flex-1 mt-3">
                                <p>Тип фигури</p>
                                <div class="flex flex-row justify-around item-center">
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" checked value="black"
                                                   name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Черный</span>
                                        </label>
                                    </div>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" value="pink" name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Розовый</span>
                                        </label>
                                    </div>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" value="white" name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Белый</span>
                                        </label>
                                    </div>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" value="blue" name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Синий</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="block max-w-xs mx-auto my-4 ">
                                    <input type="file" wire:model="photoFile">
                                    @if($errors->isNotEmpty())
                                        @error('photoFile') <span class="error">{{ $message }}</span> @enderror
                                    @elseif($photoFile !== null)
                                        <span>Добавлена картинка</span>
                                    @else
                                        <span>Добавить картинку</span>
                                    @endif
                                    <div wire:loading wire:target="photoFile"> Uploading...</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Добавить
                            </button>
                            <button type="button"
                                    wire:click="$toggle('isOpenStoryline')"
                                    class="py-2 px-4 ml-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Список сюжетов
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
                        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg p-4">
                            <div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'settings' }"
                                 id="tab_wrapper">
                                <!-- The tabs navigation -->
                                <nav>
                                    <ul class="flex flex-row bg-gray-80">
                                        <li class="p-2 border-t border-l "
                                            :class="{ 'bg-brown text-white': tab === 'settings' }">
                                            <a class="no-underline" :class="{ 'active': tab === 'settings' }"
                                               @click.prevent="tab = 'settings'; window.location.hash = 'settings'"
                                               href="#">Настройки</a></li>
                                        <li class="p-2 border-t border-l border-r "
                                            :class="{ 'bg-brown text-white': tab === 'storyline' }">
                                            <a class="no-underline" :class="{ 'active': tab === 'storyline' }"
                                               @click.prevent="tab = 'storyline'; window.location.hash = 'storyline'"
                                               href="#">Сюжеты</a></li>
                                    </ul>
                                </nav>
                                <div class="border p-4">
                                    <!-- The tabs content -->
                                    <div class="border" x-show="tab === 'settings'">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Номер
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Название
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Задержка
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Фигура
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Контент
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">

                                            @if($allMessages->isNotEmpty())
                                                @foreach($allMessages as $key=>$item)
                                                    <tr>
                                                        <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                                            <p class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{data_get(collect($item)->all(), 'id')}}</p>
                                                        </td>
                                                        <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                                            <p class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{data_get(collect($item)->all(), 'title')}}</p>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                                            <p class="text-sm text-gray-900 text-center">{{data_get(collect($item)->all(), 'delay')}}

                                                                @if(data_get(collect($item)->all(), 'delay_type') == 'seconds')
                                                                    c.
                                                                @elseif(data_get(collect($item)->all(), 'delay_type') == 'minutes')
                                                                    м.
                                                                @elseif(data_get(collect($item)->all(), 'delay_type') == 'hours')
                                                                    ч.
                                                                @elseif(data_get(collect($item)->all(), 'delay_type') == 'days')
                                                                    д.
                                                                @else
                                                                    Не задано
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap w-1/12">

                                                            @switch(data_get(collect($item)->all(), 'figure'))
                                                                @case('black')
                                                                <p class="text-sm text-gray-900 text-center text-white">
                                                                    Черная</p>
                                                                @break
                                                                @case('blue')<p
                                                                        class="text-sm text-gray-900 text-center text-white">
                                                                    Синяя</p>
                                                                @break
                                                                @case('white')<p
                                                                        class="text-sm text-gray-900 text-center">
                                                                    Белая</p>
                                                                @break
                                                                @case('pink')<p
                                                                        class="text-sm text-gray-900 text-center">
                                                                    Розовая</p>
                                                                @break
                                                                @default<p
                                                                        class="text-sm text-gray-900 text-center">Не
                                                                    назначено</p>
                                                                @break
                                                            @endswitch
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap w-3/5">
                                                            @if(data_get(collect($item)->get('pivot'), 'stepgable_type') == App\Models\Image::class)
                                                                <img src="{{data_get(collect($item)->all(), 'url')}}"
                                                                     class=""/>
                                                            @else
                                                                <p>...</p>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{route('image_edit', [data_get(collect($item)->all(), 'id'), 'step'])}}"
                                                               class="text-green-600 hover:text-green-900">Редактировать</a>
                                                            <span>|</span>
                                                            <a href="#" wire:click.prevent="removeMessage({{$key}})"
                                                               class="text-red-600 hover:text-red-900">Удалить</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        Нет созданых клеток...
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">

                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- More people... -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div x-show="tab === 'storyline'">
                                        <form>
                                            <button type="button"
                                                    wire:click="detachStoryline"
                                                    class="py-2 mb-4 px-4 ml-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                                    tabindex="-1">
                                                Отключить
                                            </button>
                                            @foreach($step->storyline as $item)
                                                <div class="flex flex-row">
                                                    <div class="mt-1">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" value="{{ $item->pivot->id }}" wire:model="detach"
                                                                   class="form-checkbox h-6 w-6 text-green-500">
                                                            <span class="ml-3 text-sm">{{$item->name}}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal.info wire:model="isOpenStoryline" maxWidth="2xl">
        <x-slot name="title">
            Выбора сюжетов
        </x-slot>

        <x-slot name="content">
            <form>
                @foreach($allStoryline as $item)
                    <div class="flex flex-row">
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="{{ $item->id }}" wire:model="storyline"
                                       class="form-checkbox h-6 w-6 text-green-500">
                                <span class="ml-3 text-sm">{{$item->name}}</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('isOpenStoryline')">
                Закрыть
            </x-jet-secondary-button>

            <x-button.success class="ml-2" wire:click="addStoryline">
                Добавить
            </x-button.success>
        </x-slot>
    </x-modal.info>
</div>
