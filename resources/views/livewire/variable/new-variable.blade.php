<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <div class="flex flex-wrap justify-center">
                        <div class="flex-initial w-1/3">
                            <input wire:model="designation" class="{{$classes}}" placeholder="Переменая ">

                            @if($errors->isNotEmpty())
                                @error('designation') <span
                                        class="font-bold text-red-500">{{ $message }}</span> @enderror
                            @else
                            @endif
                        </div>
                        <div class="flex-shrink-0 pl-4 h-32 w-1/2">
                            <textarea wire:model="description" class="{{$classes}} h-full" placeholder="Описание"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button wire:click="add"
                                type="button"
                                class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                tabindex="-1">
                            Добавить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4 ">
        <div class="flex flex-col">
            <div class="flex-initial w-1/3">
                <input wire:model="search" class="{{$classes}}" placeholder="Поиск">
            </div>
            <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Переменная
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Описание
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                               @forelse($list as $item)
                                   <tr>
                                       <td class="px-6 py-4 whitespace-nowrap">
                                           <div class="text-sm text-gray-900">{{$item->designation}}</div>
                                       </td>
                                       <td class="px-6 py-4 whitespace-nowrap">
                                           <div class="text-sm text-gray-900">{{\Illuminate\Support\Str::of($item->description)->limit(50)}}</div>
                                       </td>
                                       <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                           <a href="{{route('variable_edit', $item->id)}}"
                                              class="text-green-600 hover:text-green-900">Редактировать</a>
                                           <span>|</span>
                                           <a href="#" wire:click.prevent="remove({{$item->id}})"
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

