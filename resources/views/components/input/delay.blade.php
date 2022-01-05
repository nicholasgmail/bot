
<div class="flex flex-row flex-auto items-stretch py-4">
    <div class="inline-block pr-3">
        <select wire:model="delay_type" id="delayType"
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
