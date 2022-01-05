@props(['colors'])

<div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'white' }"
     id="tab_wrapper">
    <!-- The tabs navigation -->
    <nav>
        <ul class="flex flex-row bg-gray-80">
         {{--   @foreach($сolors as $key=>$color)
                <li class="p-2 border-t border-l "
                    :class="{ 'bg-brown text-white': $wire.tab === '{{$key}}' }">
                    <a class="no-underline" :class="{ 'active': $wire.tab === '{{$key}}' }"
                       @click.prevent="$wire.tab = '{{$key}}'; window.location.hash = '{{$key}}'"
                       href="#">{{$color}}</a></li>
            @endforeach--}}

            <li class="p-2 border-t border-l border-r "
                :class="{ 'bg-brown text-white': $wire.tab === 'black' }">
                <a class="no-underline" :class="{ 'active': $wire.tab === 'black' }"
                   @click.prevent="$wire.tab = 'black'; window.location.hash = 'black'"
                   href="#">чёрный</a></li>
        </ul>
    </nav>
    <div class="border p-4">
        <!-- The tabs content -->
        <div x-show="$wire.tab === 'white'">
            белый @json($colors)
        </div>
        <div x-show="$wire.tab === 'black'">
            чёрный
        </div>
    </div>
</div>
