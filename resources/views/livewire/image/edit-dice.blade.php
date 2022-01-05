<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit.prevent="save" enctype="multipart/form-data">
                        <div class="flex flex-row flex-wrap justify-start flex-auto flex-1 gap-6">
                            <div class="flex-shrink sm:w-1/4">
                                @if($type == 'dice')
                                    <label for="transition_model">Текст к кубику</label>
                                    <textarea wire:model.lazy="title" id="title" rows="9" class="{{$classes}}"
                                              required
                                              placeholder="Послание"></textarea>
                                    @if($errors->has('title'))
                                        @error('title') <p class="error ">{{ $message }}</p> @enderror
                                    @endif
                                @else
                                    <label for="transition_model">Карта</label>
                                    <input wire:model="transition_model" id="transition_model"
                                           type="text"
                                           required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    @if($errors->has('text'))
                                        @error('text') <p class="error ">{{ $message }}</p> @enderror
                                    @endif
                                @endif

                                @if($type == 'dice')
                                    <div class="flex-initial pt-2 mb-4">
                                             <textarea wire:model.lazy="caption" name="caption" rows="9"
                                                       class="{{$classes}} "
                                                       placeholder=""></textarea>
                                        <p>рандомный набор</p>
                                        @if($errors->has('caption'))
                                            @error('caption') <p class="error">{{ $message }}</p> @enderror
                                        @else
                                            <p>Измени запись</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="flex-shrink w-full md:w-64">
                                <img class="max-w-full m-auto block" src="{{$image->url}}" alt="картинка">
                                <div class="max-w-xs mx-auto my-4">
                                    <input type="file" wire:model="photoFile" name="photoFile">
                                    @if($errors->has('photoFile'))
                                        @error('photoFile') <span class="error">{{ $message }}</span> @enderror
                                    @elseif($photoFile !== null)
                                        <span>Добавлена картинка</span>
                                    @else
                                        <span>Добавить картинку</span>
                                    @endif
                                    <div wire:loading wire:target="photoFile">
                                        <div id="overlay" x-show="!$wire.photoFile">
                                            <div class="spinner"></div>
                                            <br/>
                                            Loading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row flex-auto">
                            <div class="w-full md:w-5/12">
                                <div class="flex flex-row flex-wrap items-stretch gap-4">
                                    @if($type == 'dice')
                                        <div class="flex-initial pt-2">
                                            <label for="priority">Номер порядковый</label>
                                            <input wire:model="priority" id="priority" name="priority" type="text"
                                                   required
                                                   class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                                   placeholder="1" value="1">
                                        </div>
                                    @endif
                                    <div class="flex-initial">
                                        <div class="inline-block pr-2">
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
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

