<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp
    <div class="pt-12 h-48" x-data="{ open: @entangle('open'), open_test: @entangle('open_test') }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 relative">
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-50"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-5000"
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
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 relative">
                <div x-show="open_test"
                     x-transition:enter="transition ease-out duration-50"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-5000"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90">
                    @if (session()->has('test'))
                        <div class="bg-green-200 p-6 border border-green-300 bg-yellow-900">
                            {{ session('test') }}
                        </div>
                    @endif
                    <button class="absolute top-0 right-0 p-4" wire:click="close">X</button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto h-auto sm:px-6 lg:px-8">
            <div class="shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <div class="flex flex-wrap justify-center sm:flex-row flex-col">
                        <div class="flex-initial pl-4 sm:w-1/2 w-full">
                            <div class="flex flex-col flex-wrap justify-between gap-4">
                                <div class="flex-initial w-full">
                                    <label for="designation">Название</label>
                                    <input wire:model="designation" class="{{$classes}}"
                                           placeholder="Переменая">

                                    @if($errors->isNotEmpty())
                                        @error('designation') <span
                                                class="font-bold text-red-500">{{ $message }}</span> @enderror
                                    @else
                                    @endif
                                </div>
                                <div class="flex-initial w-full mt-4">
                                    <label for="designation">Описание</label>
                                    <textarea wire:model="description"
                                              class="{{$classes}}"
                                              rows="8"
                                              placeholder="Описание"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="flex-initial pl-4 sm:w-1/2 w-full  mt-3 sm:mt-0">
                            <label for="designation">Код</label>
                            <textarea wire:model="code"
                                      rows="13"
                                      class="{{$classes}}"
                                      placeholder="Код переменной"></textarea>
                        </div>
                    </div>
                    <div class="flex flex-row justify-center">
                        <div class="text-center mt-4" @click="setTimeout(() => {return open=false;}, 6000)">
                            <button wire:click="updateVariable"
                                    {{--@click="open=setTimeout(() => {console.log('hello');return open=!open}, 3000)"--}}
                                    type="button"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                {{ __("Сохранить") }}
                            </button>
                        </div>
                        <div class="text-center ml-4 mt-4">
                            <button wire:click="test"
                                    type="button"
                                    class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                                    tabindex="-1">
                                {{ __("Тест") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto h-auto sm:px-6 lg:px-8">
            <div class="shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <div class="flex flex-wrap justify-start">
                        <div class="w-1/2 border border-white p-2 mt-3">
                            <h4 class="text-red-300 text-2xl font-bold">{{ __("Параметры игрока") }}</h4>
                            <ul>
                                <li><p>id : <span class="text-yellow-300 font-bold">{{$dialog_id}}</span></p></li>
                                @foreach($upshot as $key=>$item)
                                    <li><p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="w-1/2 border border-white p-2 mt-3">
                            <livewire:components.variable.point-a :categorye="$category"/>
                        </div>
                        <div class="w-1/2 border border-white p-2 mt-3">
                            <livewire:components.variable.briefcase :upshot="$upshot"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--@push('scripts')
<script>

</script>
@endpush--}}
