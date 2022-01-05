<div>
    <div class="inline-flex text-left">
        <div x-data="{ isOpen: false }">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <div class="mt-1 flex items-center rounded-md shadow-sm">
                            <form method="POST" action="{{route('setting.store')}}" role="none">
                                {{csrf_field()}}
                                <div class="flex">
                                    <div class="mr-3">
                                        <button type="button" @click="isOpen = !isOpen"
                                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                                                id="menu-button" aria-expanded="true" aria-haspopup="true">
                                            Действие
                                            <!-- Heroicon name: solid/chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20"
                                                 fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <div x-show="isOpen"
                                             x-transition:enter="transition ease-out duration-100 transform"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75 transform"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="origin-top-right absolute left-1 mt-2 w-56 rounded-md shadow-lg bg-white"
                                             role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                             tabindex="-1">
                                            <div class="py-1" role="none">
                                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                <a href="#"
                                                   onclick="document.getElementById('url_callback_bot').value='{{url('')}}'"
                                                   class="text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                                   tabindex="-1"
                                                   id="menu-item-0">Вставить
                                                    url</a>
                                                <a href="#" class="text-gray-700 block px-4 py-2 text-sm"
                                                   onclick="event.preventDefault(); document.getElementById('setwebhook').submit();"
                                                   role="menuitem"
                                                   tabindex="-1"
                                                   id="menu-item-1">Отправить url</a>
                                                <a href="#" class="text-gray-700 block px-4 py-2 text-sm"
                                                   onclick="event.preventDefault(); document.getElementById('getwebhookinfo').submit();"
                                                   role="menuitem"
                                                   tabindex="-1"
                                                   id="menu-item-2">Получить информацию</a>
                                                <button type="submit"
                                                        class="text-gray-700 block w-full text-left px-4 py-2 text-sm"
                                                        role="menuitem"
                                                        tabindex="-1" id="menu-item-3">
                                                    Sign out
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="url" wire:model="name" name="url_callback_bot" id="url_callback_bot"
                                           value=""
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="www.example.com">

                                </div>
                                <br>
                                <input type="text" name="site_name"
                                       value="{{ $name or ''}}"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="www.example.com">
                                <br>
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Сохранить
                                </button>

                            </form>
                            <a href="{{route('testTocken')}}"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                test
                            </a>
                            <form id="setwebhook" action="{{route('setting.setwebhook')}}" method="POST" style="display: none">
                                {{csrf_field()}}
                                <input type="hidden" name="url" wire:model="name" value="{{ $name or ''}}">
                            </form>
                            <form id="getwebhookinfo" action="{{route('setting.getwebhookinfo')}}" method="POST" style="display: none">
                                {{csrf_field()}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
