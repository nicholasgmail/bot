<div x-data="{ open: @entangle('open').defer, not:@entangle('notify')}" @notify="alert(not)">
    <button @click="open=!open"
            class="py-2 px-4 text-white bg-blue text-center w-full font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
            tabindex="-1">
        {{$cell}}
    </button>
    <form wire:submit.prevent="save"  enctype="multipart/form-data" class="absolute bg-white h-full inset-0 overflow-hidden  p-4" x-show="open" x-transition.ration.500ms>
        <div class="h-full overflow-y-scroll m-auto" {{--style="height: 99%; overflow-y: scroll; margin: auto;"--}}>
            <div class="flex flex-wrap flex-col justify-between" style="width:99%;">
                <div class="flex-1">
                    <div class="flex flex-wrap justify-between">
                        Настрой ячейку № {{$cell}}
                        <div class="flex-0 p-4">
                            <a wire:click="close"
                                    type="button"
                                    class="py-2 px-4 text-white font-semibold no-underline cursor-pointer bg-blue text-center rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Закрыть
                            </a>
                        </div>
                        <div class="flex-0 p-4">
                            <button {{--@click="$dispatch('notify')"--}}
                                    type="submit"
                                    class="py-2 px-4 text-white font-semibold bg-blue text-center rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <p>Тип фигури</p>
                    <div class="flex flex-row justify-around item-center">
                        <div class="flex-1">
                            <div class="inline-flex flex-row">
                                @foreach($сolors as $key=>$color)
                                    <div class="mt-1 ml-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model.lazy.defer="option"
                                                   @if($option === $key) checked
                                                   @endif
                                                   value="{{$key}}"
                                                   name="variant"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{$color}}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <div class="inline-flex">
                                <x-input.delay></x-input.delay>
                            </div>
                        </div>
                        <div class="flex-1 max-w-xs mx-auto my-4 ">
                            <div class="flex" style="flex-direction: column">
                                <div class="flex-auto pt-2 mb-4">
                                    <label for="transition_model">модель перехода</label>
                                    <input wire:model.defer.lazy="transition_model"
                                           id="transition_model"
                                           type="text"
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    @if($errors->has('text'))
                                        @error('text') <span class="error">{{ $message }}</span> @enderror
                                    @else
                                        <p class="text-sm">номерация перехота вида 1-2 или 1-5-6</p>
                                    @endif
                                </div>
                                <div class="flex-auto">
                                    <input type="file" wire:model="photoFile">
                                    @if($errors->has('photoFile'))
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
                    </div>
                </div>
                <div class="flex-1">
                    <nav>
                        <ul class="flex flex-row bg-gray-80">
                            @foreach($сolors as $key=>$color)
                                <li class="p-2 border-t border-l  @if ($loop->last) border-r @endif "
                                    :class="{ 'bg-brown text-white': $wire.tab === '{{$key}}' }">
                                    <a class="no-underline" :class="{ 'active': $wire.tab === '{{$key}}' }"
                                       @click.prevent="$wire.tab = '{{$key}}'; window.location.hash = '{{$key}}'"
                                       href="#">{{$color}}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                    <div class="border p-4">
                        <!-- The tabs content -->
                        @foreach($сolors as $key=>$color)
                            <div x-show="$wire.tab === '{{$key}}'">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Маршрут
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Задержка
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

                                    @if($transition_images->isNotEmpty())
                                        @foreach($transition_images->sortBy(function ($value){return data_get($value, 'pivot.transition_model');}) as $key_image=>$image)
                                            @if ($key == data_get($image, 'figure'))
                                                <tr>
                                                    <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                                        <p class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{data_get($image, 'pivot.transition_model')}}</p>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                                        <p
                                                            class="text-sm text-gray-900 text-center">{{data_get($image, 'delay')}}
                                                            @if(data_get($image, 'delay_type') == 'seconds') c.
                                                            @elseif(data_get($image, 'delay_type') == 'minutes')
                                                                м.
                                                            @elseif(data_get($image, 'delay_type') == 'hours')
                                                                ч.
                                                            @elseif(data_get($image, 'delay_type') == 'days') д.
                                                            @else
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap" style="width: 20%;">
                                                        <img src="{{data_get($image, 'url')}}"/>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{route('image_edit', [data_get($image, 'id'), 'game'])}}"
                                                           class="text-green-600 hover:text-green-900">Редактировать</a>
                                                        <a
                                                            wire:click="remove({{data_get($image, 'id')}})"
                                                            class="text-red-600 no-underline cursor-pointer hover:text-red-900">Удалить
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
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
                                    @endif
                                    <!-- More people... -->
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap justify-end">
                        <div class="flex-0 p-4">
                            <button {{--@click="$dispatch('notify')"--}}
                                    type="submit"
                                    class="py-2 px-4 text-white font-semibold bg-blue text-center rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
