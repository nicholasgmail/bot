<div>
    <div class="flex flex-row flex-wrap mb-3">
        <div class="self-center">
            <button wire:click="copy"
                    class="py-2 px-4 bg-green-700 text-white font-semibold rounded-lg shadow-md hover:bg-cyan-900 focus:outline-none"
                    tabindex="-1">
                Копировать
            </button>
        </div>
    </div>
    <div class="overflow-hidden">
        <div class="overflow-y-scroll h-96">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="ext-left px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Контекст
                    </th>
                    <th scope="col" class="relative px-1 py-1">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
                </thead>
                @foreach($messages as $key=>$item)
                    <tbody class="bg-white divide-y divide-gray-200">

                    @if(is_null($item))
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Не содержит сообщений...
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                            </td>
                        </tr>
                    @else
                        <livewire:components.table.item-copy :item="$item" :key="$key"/>
                        {{-- <tr>
                             <td class="px-6 py-4 whitespace-nowrap">
                                 <div class="flex flex-col md:flex-row justify-center item-center gap-2">
                                     <div class="flex-1 self-center">
                                         <div class="flex items-center">
                                             <div class="flex-shrink-0 h-10 w-10">
                                                 <img class="h-10 w-10 rounded-full"
                                                      src="{{class_basename(data_get($item, 'pivot.storylinegable_type')) == 'Video' ?  'https://place-hold.it/300x500?text=%D0%9F%D1%83%D1%81%D1%82%D0%BE' : data_get($item, 'url') ?? 'https://place-hold.it/300x500?text=%D0%9F%D1%83%D1%81%D1%82%D0%BE'}}"
                                                      alt="{{data_get($item, 'title')}}">
                                             </div>
                                             <div class="overflow-ellipsis overflow-hidden ml-4 w-32 md:w-60">
                                                 <div class="text-sm text-left font-medium text-gray-900">
                                                     {{data_get($item, 'title')}}
                                                 </div>
                                                 <div class="text-sm text-left text-gray-500">
                                                     {{data_get($item, 'caption')}}
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="self-center">
                                         <div class="flex-1 self-center">
                                             <label class="flex items-center space-x-3">
                                                 <input wire:model.lazy="checked"  type="checkbox" name="checked-demo"
                                                        class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                                                 <span class="text-gray-900 font-medium"></span>
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                         </tr>--}}
                    @endif
                    <!-- More people... -->
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
