<div class="w-full md:w-6/12">
    <div class="block pt-2">
        <div class="pt-1" style="text-align: start;">
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="involve"
                       class="form-checkbox h-6 w-6 text-green-500">
                <span class="ml-3 text-sm">{{__('Проверка по условию')}}</span>
            </label>
        </div>
    </div>
    @if($involve)
    <div class="block pt-2 mb-4 w-100">
        <label for="title">{{__('Условие для проверки')}}</label>
        <textarea wire:model.lazy="code" rows="9" class="{{$classes}}"
                  placeholder="Текст"></textarea>
    </div>
    @endif
</div>
