<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sticky top-2/4 left-2/4"
         x-data="{ open_test: @entangle('open_test') }">
        <div x-show="open_test" class="mb-4 relative">
            <div
                    x-transition:enter="transition ease-out duration-50"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-5000"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90">
                @if (session()->has('test'))
                    <div class="bg-green-200 p-6 border border-green-300 bg-yellow-900 opacity-100">
                        {{ session('test') }}
                    </div>
                    <button class="absolute top-0 right-0 p-4" wire:click="close">X</button>
                @endif
            </div>
        </div>
    </div>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit.prevent="addContent" enctype="multipart/form-data">
                        <div class="flex flex-col sm:flex-row flex-auto gap-6">
                            <div class="flex-1">
                                <div class="inline-block pt-2 mb-4">
                                    <label for="title">Заголовок</label>
                                    @if($errors->has('title'))
                                        @error('title') <span class="error">{{ $message }}</span> @enderror
                                    @endif
                                    <input wire:model="title" id="title" name="title" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                                <textarea wire:model="text" rows="9" class="{{$classes}}"
                                          placeholder="Послание"></textarea>
                                @if($errors->has('text'))
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
                            <div class="flex-1">
                                <div class="block">
                                    <div class="mt-3">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" checked value="message"
                                                   name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Сообщение</span>
                                        </label>
                                    </div>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" value="image" name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Сообщение с картинкой</span>
                                        </label>
                                    </div>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="option" value="video" name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">Сообщение с видео</span>
                                        </label>
                                    </div>
                                </div>
                                @if($image)
                                    <div class="max-w-xs mx-auto mb-4">
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
                                @elseif($video)
                                    <div class="max-w-xs mx-auto mb-4">
                                        <input type="file" wire:model="videoFile">
                                        @if($errors->isNotEmpty() && $videoFile === null)
                                            @error('videoFile') <span class="error">{{ $message }}</span> @enderror
                                        @elseif($videoFile !== null)
                                            <span>Добавлено видео</span>
                                        @else
                                            <span>Добавить видео</span>
                                        @endif
                                        <div wire:loading wire:target="videoFile"> Uploading...</div>
                                    </div>
                                @endif
                                {{--<div class="block">
                                    <img src="https://placeimg.com/640/480/animals" class="object-contain h-44 max-w-full">
                                </div>--}}
                            </div>

                        </div>
                        <div class="flex">
                            <div class="flex-initial p-2 text-left border-2 border-red-500">
                                <p>код для тестов</p>
                                {{$hash}}
                                <br>
                                <button type="button"
                                        wire:click="gen"
                                        class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                        tabindex="-1">
                                    Ключ
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Добавить
                            </button>
                            <button type="button"
                                    wire:click="open"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Выбрать
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
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                                        Приоритет
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


                                @forelse($allMessages as $key=>$item)
                                    <tr>
                                        <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                            <p class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{$item['id']}}</p>
                                        </td>
                                        <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                            <p
                                                    class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{$item['title']}}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                            <p
                                                    class="text-sm text-gray-900 text-center">{{data_get($item, 'option.delay')}}
                                                @if(data_get($item, 'option.delay_type') == 'seconds') c.
                                                @elseif(data_get($item, 'option.delay_type') == 'minutes') м.
                                                @elseif(data_get($item, 'option.delay_type') == 'hours') ч.
                                                @elseif(data_get($item, 'option.delay_type') == 'days') д.
                                                @else
                                                @endif
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                            <p class="text-sm text-gray-900 text-center">{{data_get($item, 'option.priority')}}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(data_get($item, 'pivot.storylinegable_type') == App\Models\Image::class)
                                                <div class="w-2/5">
                                                    <img src="{{$item['url']}}" class=""/>
                                                </div>
                                            @elseif(data_get($item, 'pivot.storylinegable_type') == App\Models\Video::class)
                                                <div class="w-2/5">
                                                    <video src="{{$item['url']}}"></video>
                                                </div>
                                            @else
                                                <p>...</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(data_get($item, 'pivot.storylinegable_type') == App\Models\Image::class)
                                                <a href="{{route('image_edit', [$item['id'], 'storyline'])}}"
                                                   class="text-green-600 hover:text-green-900">Редактировать</a>
                                            @elseif(data_get($item, 'pivot.storylinegable_type') == App\Models\Video::class)
                                                <a href="{{route('video_edit', $item['id'])}}"
                                                   class="text-green-600 hover:text-green-900">Редактировать</a>
                                            @else
                                                <a href="{{route('message_edit', $item['id'])}}"
                                                   class="text-green-600 hover:text-green-900">Редактировать</a>
                                            @endif
                                            <span>|</span>
                                            <a href="#"
                                               wire:click.prevent="test({{$item['id']}}, '{{class_basename(data_get($item, 'pivot.storylinegable_type'))}}')"
                                               class="text-blue-600 hover:text-blue-900">Тест</a>
                                            <span>|</span>
                                            <a href="#" wire:click.prevent="removeMessage({{$key}})"
                                               class="text-red-600 hover:text-red-900">Удалить</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            Нет созданых игр...
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
                                @endforelse
                                <!-- More people... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($isOpenWhere)
        <x-modal.info wire:model="isOpenWhere" maxWidth="2xl">
            <x-slot name="title">
                Добавить сообщения
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

                @if($context_type == 'messages')
                    <livewire:components.tables.table-messages-copy :messages="$all_messages"/>
                @else
                    <div class="overflow-hidden">
                        <div class="overflow-y-scroll h-96">
                            <livewire:components.tables.table-storylines :storylines="$all_storylines"/>
                        </div>
                    </div>
                @endif

            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end gap-4">
                    <div class="self-center">
                        <button wire:click="$toggle('isOpenWhere')"
                                class="py-2 px-4 bg-red-900 text-white font-semibold rounded-lg shadow-md hover:bg-white hover:text-red-900 focus:outline-none"
                                tabindex="-1">
                            Закрыть
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-modal.info>
    @endif
</div>
