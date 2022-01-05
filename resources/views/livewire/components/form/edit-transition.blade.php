<div class="flex flex-row justify-between items-baseline gap-6">
    <div class="flex-1">
        <label  for="name" class="text-sm">Название</label>
        <input wire:model.lazy="name" id='name' type="text"
               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
    </div>
    <div class="flex-initial text-sm w-40">
        <label for="title">Вес</label>
        <input wire:model.lazy="weight" type="text"
               class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
        <span class="ml-1 text-xs">Ограничение выбора 1-2</span>
    </div>
    <div class="flex-1 self-center">
        <label class="flex items-center space-x-3">
            <input wire:model.lazy="btn_random"  type="checkbox" name="checked-demo"
                   class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
            <span class="text-gray-900 font-medium">Рандом</span>
        </label>
    </div>
</div>
