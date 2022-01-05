<div x-data="{ open: @entangle('open') }">
    <div class="mb-4 relative">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90">
            @if (session()->has('message'))
                <div class="bg-green-30 p-6 border border-gray-300 bg-red-300">
                    {{ session('message') }}
                </div>
            @endif
            <button class="absolute top-0 right-0 p-4" wire:click="close">X</button>
        </div>
    </div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp
    <div id="overlay" x-show="!$wire.tabs">
        <div class="spinner"></div>
        <br/>
        Loading...
    </div>
    <div x-show="!!$wire.tabs">
        <nav>
            <ul class="flex flex-row bg-gray-80">
                @foreach($tabs as $key=>$item)
                    <li class="p-2 border-t border-l @if ($loop->last)border-r @endif"
                        :class="{ 'bg-white text-black': $wire.tab === '{{$key}}' }">
                        <a class="no-underline" :class="{ 'active': $wire.tab === '{{$key}}' }"
                           @click.prevent="$wire.tab = '{{$key}}'; window.location.hash = '{{$key}}'"
                           href="#">{{$item}}</a></li>
                @endforeach
            </ul>
        </nav>
        <div class="border p-4">
            <!-- The tabs content -->
            @foreach($tabs as $key=>$item)
                <div x-show="$wire.tab === '{{$key}}'">
                    @if($key == 'greetings')
                        <div>
                        <textarea wire:model.lazy.defer="salute" rows="5" class="{{$classes}}"
                                  placeholder="Приветствие"></textarea>
                        </div>
                    @elseif($key == 'emoji')
                        <div>
                        <textarea wire:model.lazy.defer="emoji" rows="5" class="{{$classes}}"
                                  placeholder="Емодзи"></textarea>
                        </div>
                    @elseif($key == 'men')
                        <div>
                        <textarea wire:model.lazy.defer="men" rows="5" class="{{$classes}}"
                                  placeholder="Мужские"></textarea>
                        </div>
                    @elseif($key == 'women')
                        <div>
                        <textarea wire:model.lazy.defer="women" rows="5" class="{{$classes}}"
                                  placeholder="Женские"></textarea>
                        </div>
                    @else
                        <div>
                        <textarea wire:model.lazy="mistake" rows="5" class="{{$classes}}"
                                  placeholder="Ответ на ошибки"></textarea>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-center mt-4" @click="setTimeout(() => {return open=false;}, 6000)">
        <button wire:click="save"
                class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                tabindex="-1">
            Сохранить
        </button>
    </div>
</div>
