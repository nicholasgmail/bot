<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <div class="max-w-xs mx-auto">
                        <input wire:model="name" class="{{$classes}}" placeholder="Клетка">

                        @if($errors->isNotEmpty())
                            @error('name') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
                        @else
                            <span>Ведди название категории от 3 до 64 символов</span>
                        @endif
                    </div>
                    <div class="text-center mt-4">
                        <button wire:click="addStep"
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
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Название
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                            @if($allStep->isNotEmpty())
                                @foreach($allStep as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{$item->name}}</div>
                                            {{--<div class="text-sm text-gray-500">Optimization</div>--}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{route('step_edit', $item->id)}}" class="text-green-600 hover:text-green-900">Редактировать</a>
                                            <span>|</span>
                                            <a href="#" wire:click.prevent="removeStep({{$item->id}})"  class="text-red-600 hover:text-red-900">Удалить</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        Нет созданых категорий...
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

