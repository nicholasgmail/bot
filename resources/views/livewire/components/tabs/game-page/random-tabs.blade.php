<div x-data>
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
                        <div wire:click="get">
                        <textarea wire:model.lazy="salute" rows="5" class="{{$classes}}"
                                  placeholder="Приветствие"></textarea>
                        </div>
                    @elseif($key == 'emoji')
                        <div wire:click="get">
                        <textarea wire:model.lazy="emoji" rows="5" class="{{$classes}}"
                                  placeholder="Емодзи"></textarea>
                        </div>
                    @else
                        <div wire:click="get">
                        <textarea wire:model.lazy="mistake" rows="5" class="{{$classes}}"
                                  placeholder="Ответ на ошибки"></textarea>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
