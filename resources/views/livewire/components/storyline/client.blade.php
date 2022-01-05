@php
    $title = 'Доходы'
@endphp
<div>
    <div class="flex justify_between align->center">
        <div class="flex-initial w-1/2">
            <h5 class="mb-2">{{$title}}</h5></div>
        <div class="flex-initial w-1/2">
            <h6 class="mb-2 text-right text-green-300">{{$sum}}</h6></div>
    </div>
    <div class="flex flex-col flex-wrap justify-evenly gap-4">
        <div class="flex-1 w-full">
            <form wire:submit.prevent="add">
                <div class="flex flex-row justify-start align-end gap-3">
                    <div class="flex-initial">
                        <label class="inline-flex items-center">
                            {{ __('Название') }}
                        </label>
                        <input wire:model="client" type="text" class="{{$classes}}">
                        @if($errors->has('client'))
                            @error('client') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
                        @endif
                    </div>
                    <div class="flex-initial">
                        <label class="inline-flex items-center">
                            {{ __('Прибыль') }}
                        </label>
                        <input wire:model="profit" type="text" class="{{$classes}}">
                        @if($errors->has('profit'))
                            @error('profit') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
                        @endif
                    </div>

                    <div class="flex-initial self-end">
                        <button type="submit"
                                class="py-2 mb-1 px-4 bg-green-700 text-white font-semibold rounded-lg shadow-md hover:bg-green-900 focus:outline-none"
                                tabindex="-1">+
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex-1 w-full text-white">
            <div class="flex flex-col">
                @forelse($portfolio as $key=>$item)
                    <div class="flex-initial">
                        <div class="flex justify_between align->center">
                            <div class="flex-initial w-4/5">
                                <p>{{data_get($item, 'client')}} : {{data_get($item, 'profit')}}</p>
                            </div>
                            <div class="flex-initial w-1/5">
                                <a href="" wire:click.prevent="remove({{$key}})"
                                   class="text-red-300  text-left">Удалить</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>нет клиентов</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
