<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{$dice->title}}</div>
        {{--<div class="text-sm text-gray-500">Optimization</div>--}}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex justify-center">
            <div class="flex-inherity">
                <label class="flex items-center space-x-3">
                    <input wire:model="active"  type="checkbox" name="checked-demo"
                           class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                    <span class="text-gray-900 font-medium"></span>
                </label>
                {{--<label for="toggleB" wire:click="toggle({{$dice->id}})" class="flex items-center cursor-pointer">
                    <!-- toggle -->
                    <div class="relative">
                        <!-- input -->

                        <input type="checkbox" id="toggleB" class="sr-only">
                        <!-- line -->
                        <div x-bind:class.debounce="open ? 'bg-yellow-600' : 'bg-gray-600'"
                             class="block  w-8 h-4 rounded-full"></div>
                        <!-- dot -->
                        <div x-bind:class.debounce="open ? 'right-0.5 top-0.5' : 'inset-0.5'"
                             class="dot absolute bg-white w-3 h-3 rounded-full transition"></div>
                    </div>
                    <!-- label -->
                    <div class="ml-3 text-gray-700 font-medium">
                    </div>
                </label>--}}
            </div>
        </div>
        {{--<div class="text-sm text-gray-500">Optimization</div>--}}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <a href="{{route('dice_edit', $dice->id)}}"
           class="text-green-600 hover:text-green-900">Редактировать</a>
        <span>|</span>
        <a href="#" wire:click.prevent="remove({{$dice->id}})"
           class="text-red-600 hover:text-red-900">Удалить</a>
    </td>
</tr>
