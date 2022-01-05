<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit="addDice" enctype="multipart/form-data">
                        <div class="flex flex-col sm:flex-row flex-auto gap-6">
                            <div class="flex-1">
                                <div class="inline-block pt-2 mb-4">
                                    <label for="title">Заголовок</label>
                                    <textarea wire:model="title" id="title" rows="9" class="{{$classes}}"
                                              required
                                              placeholder="Послание"></textarea>
                                    @if($errors->has('title'))
                                        @error('title') <span class="error">{{ $message }}</span> @enderror
                                    @endif
                                </div>
                                <textarea wire:model="caption" rows="9" class="{{$classes}}"
                                          placeholder="Послание"></textarea>
                                @if($errors->has('text'))
                                    @error('text') <p class="error">{{ $message }}</p> @enderror
                                @else
                                    <p>Сделай запись</p>
                                @endif
                                <div class="inline-block pt-2">
                                    <label for="priority">Номер кубика</label>
                                    <input wire:model="priority" id="priority" name="priority" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                           placeholder="1" value="1">
                                </div>
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
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Добавить
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
                                       #
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Номер
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Задержка
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Картинка
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Сообщения
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">

                                @if(!is_null($allDice))
                                    @foreach($allDice as $key=>$item)
                                       {{-- <livewire:components.table.item-dice :dice="$item" :key="$key"/>--}}
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                                <p
                                                        class="text-sm text-gray-900 whitespace-pre-wrap text-center">{{$item->option->priority}}</p>
                                            </td>
                                            <td class="overflow-hidden px-6 py-4 whitespace-nowrap w-2/12">
                                                <p
                                                        class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{$item['title']}}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap w-1/12">
                                                <p
                                                        class="text-sm text-gray-900 text-center">{{$item->option->delay}}
                                                    @if($item->option->delay_type == 'seconds') c.
                                                    @elseif($item->option->delay_type == 'minutes') м.
                                                    @elseif($item->option->delay_type == 'hours') ч.
                                                    @elseif($item->option->delay_type == 'days') д.
                                                    @else
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap w-20">
                                                    <img src="{{$item->url}}" class=""/>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap w-20">
                                                <p
                                                        class="truncate max-w-xs text-sm text-gray-900 whitespace-pre-wrap text-center">{{$item->caption}}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{route('image_edit', [$item['id'], 'dice'])}}"
                                                       class="text-green-600 hover:text-green-900">Редактировать</a>
                                                <span>|</span>
                                                <a href="#" wire:click.prevent="removeMessage({{$item->id}})"  @click="location.reload()"
                                                   class="text-red-600 hover:text-red-900">Удалить</a>
                                            </td>
                                        </tr>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
