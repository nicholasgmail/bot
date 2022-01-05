<div class="flex-auto">
    <div class="flex justify-between">
        <div class="flex-initial" x-data="">
            <div class="flex-auto">
                <p>Расход</p>
                <div class="max-w-xs me-auto">
                    <input type="radio" class="mr-4" value="disposable" wire:model="income" name="income">
                    <input type="radio" value="constant" wire:model="income" name="income">
                </div>
                @if(collect($income)->first() == "disposable")
                    <span>Одноразовый</span>
                @else
                    <span>Постоянный</span>
                @endif
            </div>
            <div class="flex-auto">
                <div class="inline-block pr-3">
                    <select wire:model.lazy="disposable_value" class="form-select text-black sm:text-sm">
                        <option value=""></option>
                        @foreach($disposable as $key=>$item)
                            @if($key == $disposable_value)
                                <option selected value="{{$key}}">{{$item}}</option>
                            @else
                                <option value="{{$key}}">{{$item}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <div class="flex-initial" x-data="">
            <div class="flex-auto">
                <p>Доход</p>
                <div class="max-w-xs me-auto">
                    <input type="radio" class="mr-4" value="disposable" wire:model="expense" name="expense">
                    <input type="radio" value="constant" wire:model="expense" name="expense">
                </div>
                @if(collect($expense)->first() == "disposable")
                    <span>Одноразовый</span>
                @else
                    <span>Постоянный</span>
                @endif
            </div>
            <div class="flex-auto">
                <div class="inline-block pr-3">
                    <select wire:model.lazy="constant_value" class="form-select text-black sm:text-sm">
                        <option value=""></option>
                        @foreach($constant as $key=>$item)
                            @if($key == $constant_value)
                                <option selected value="{{$key}}">{{$item}}</option>
                            @else
                                <option value="{{$key}}">{{$item}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
