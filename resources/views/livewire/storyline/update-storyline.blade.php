<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp
    <div class="mb-4 relative" x-data="{ open: @entangle('open') }">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90">
            @if (session()->has('message'))
                <div class="bg-green-30 p-6 border border-gray-300 bg-rose-100">
                    {{ session('message') }}
                </div>
            @endif
            <button class="absolute top-0 right-0 p-4" wire:click="close">X</button>
        </div>
    </div>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="save" class="bg-brown text-white px-4 py-4">
                    <div class="text-right my-4">
                        <button type="submit"
                                class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                tabindex="-1">
                            Сохранить
                        </button>
                    </div>
                    <div class="flex flex-row flex-wrap justify-between gap-3">
                        <div class="flex-auto">
                            <div class="inline-block pr-3">
                                <select wire:model.lazy="category_value" class="form-select text-black sm:text-sm">
                                    @if(is_null($category))
                                        <option selected value="">Категории</option>
                                    @endif
                                    @foreach($categotrie as $item)
                                        @if(!is_null($category) && $item->id == $category->id)
                                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="max-w-xs mx-auto">
                                <input wire:model="name" class="{{$classes}}">

                                @if($errors->has('name'))
                                    @error('name') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
                                @else
                                    <span>Ведди название сюжета от 3 до 64 символов</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-col">
                                <div class="flex-1">
                                    <div class="pt-1" style="text-align: end;">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="hide"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{__('Скрытый')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="pt-1" style="text-align: end;">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="show_level"
                                                   class="form-checkbox h-6 w-6 text-green-500">
                                            <span class="ml-3 text-sm">{{__('Отображать левелы')}}</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="w-full px-2 py-2">
                        <div class="border border-white p-2">
                            <livewire:components.storyline.plot-lists :storyline="$storyline"
                                                                      :classes="$classes"/>
                        </div>
                    </div>
                    <div class="w-full px-2">
                        <div class="flex flex-row">
                            <div class="w-3/5 border border-white px-2">
                                <h5 class="mb-2">Сюжет относится</h5>
                                <div class="flex flex-row flex-wrap justify-items-start gap-4">
                                    @foreach($game_types as $key=>$type)
                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="{{ $key }}" value="{{ $key }}"
                                                       wire:model.lazy.defer="selected_games"
                                                       class="form-checkbox h-6 w-6 text-green-500">
                                                <span class="ml-3 text-sm">{{ $type }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="w-2/5 border border-white px-2">
                                <livewire:components.storyline.game-type :storyline="$storyline"
                                                                         :classes="$classes"/>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-2">
                        <div class="flex flex-row">
                            <div class="w-1/2 border border-white px-2">
                                <livewire:components.storyline.complexity :storyline="$storyline"
                                                                          :classes="$classes"/>
                            </div>
                        </div>
                    </div>
                    @if($storyline->show_level)
                        <div class="w-full border border-white p-2 mt-3">
                            <livewire:components.storyline.difficulty-levels :storyline="$storyline"
                                                                             :classes="$classes"/>
                        </div>
                    @endif
                </form>

                <div class="flex flex-wrap bg-brown text-white p-2">
                    <div class="lg:w-1/5 border border-white p-2 mt-3">
                        <livewire:components.storyline.purpose-plot :storyline="$storyline"
                                                                    :classes="$classes"/>
                    </div>
                    @if(\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("благо") ||
\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("расход") ||
\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("беременность") ||
\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("займ") ||
\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("рынок") ||
\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("возможность")
)
                        <div class="lg:w-2/6 border border-white p-2 mt-3">
                            <livewire:components.storyline.put-where :storyline="$storyline"
                                                                     :classes="$classes"/>
                        </div>
                    @endif
                </div>
                @if(\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("точка а"))
                    <div class="flex flex-wrap bg-brown text-white p-2">
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.client :storyline="$storyline"
                                                                  :classes="$classes"/>
                        </div>
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.expenses :storyline="$storyline"
                                                                    :classes="$classes"/>
                        </div>
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.assets :storyline="$storyline"
                                                                  :classes="$classes"/>
                        </div>
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.passive :storyline="$storyline"
                                                                   :classes="$classes"/>
                        </div>
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.loan :storyline="$storyline"
                                                                :classes="$classes"/>
                        </div>
                        <div class="lg:w-1/2 border border-white p-2 mt-3">
                            <livewire:components.storyline.balance-a :storyline="$storyline"
                                                                     :classes="$classes"/>
                        </div>
                    </div>
                @elseif(\Illuminate\Support\Str::of($storyline->categories->first()->name ?? '')->lower()->is("благотворительность"))

                @endif
            </div>
        </div>
    </div>
</div>

