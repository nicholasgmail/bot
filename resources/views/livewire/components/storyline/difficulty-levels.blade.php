@php
    $title = 'Уровни сложности %левел_цена%'
@endphp
<div>
    <h5 class="mb-2">{{$title}}</h5>
    <div class="flex flex-row flex-wrap justify-evenly gap-4">
        @foreach($difficulty_levels as $key=>$level)
            <div class="flex-auto lg:w-1/6">
                <div class="flex flex-col justify-start">
                    <div class="flex-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="{{ $key }}" value="{{ $key }}"
                                   wire:model="select_levels"
                                   class="form-checkbox h-6 w-6 text-green-500">
                            <span class="ml-3 text-sm">{{ $level }}</span>
                        </label>
                    </div>
                    <div class="flex-1">
                        <input wire:model="{{$key}}" type="text" class="{{$classes}}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
