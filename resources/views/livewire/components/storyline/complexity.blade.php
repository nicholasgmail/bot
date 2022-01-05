@php
    $title = 'Сложность'
@endphp
<div>
    <h5 class="mb-2">{{$title}}</h5>
    <div class="flex flex-row flex-wrap justify-evenly gap-4">
        @foreach($complexity as $key=>$item)
            <div class="flex-auto lg:w-1/6">
                <div class="flex flex-col justify-start">
                    <div class="flex-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="{{ $key }}" value="{{ $key }}"
                                   wire:model="selectcomplexity"
                                   class="form-checkbox h-6 w-6 text-green-500">
                            <span class="ml-3 text-sm">{{ $item }}</span>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
