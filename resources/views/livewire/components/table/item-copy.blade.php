<tr>
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
</tr>
