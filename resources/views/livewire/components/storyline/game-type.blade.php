@php
    $title = 'Тип игры'
@endphp
<div>
    <h5 class="mb-2">{{$title}}</h5>
    <div class="flex flex-row flex-wrap justify-evenly gap-4">
        @foreach($game_type as $key=>$type)
            <div class="flex-auto lg:w-1/6">
                <div class="flex flex-col justify-start">
                    <div class="flex-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="{{ $key }}" value="{{ $key }}"
                                   wire:model="select_type"
                                   class="form-checkbox h-6 w-6 text-green-500">
                            <span class="ml-3 text-sm">{{ $type }}</span>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
