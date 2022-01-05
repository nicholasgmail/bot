@php
    $title = 'Баланс'
@endphp
<div>
    <div class="flex justify_between align->center">
        <div class="flex-initial w-1/2">
            <h5 class="mb-2">{{$title}}</h5></div>
    </div>
    <div class="flex flex-col flex-wrap justify-evenly gap-4">
        <div class="flex-1 w-full">
            <label class="inline-flex items-center">
                {{ __('Сумма') }}
            </label>
            <input wire:model="balance" type="text" class="{{$classes}}">
            @if($errors->has('balance'))
                @error('balance') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
            @endif
        </div>
    </div>
</div>
