<div class="flex-1">
    <button wire:click="setShell"
            class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
            tabindex="-1">
        Запустить
    </button>
    <button wire:click="getShell"
            class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
            tabindex="-1">
        Обновить
    </button>
    <button wire:click="stopShell"
            class="py-2 px-4 bg-yellow-700 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
            tabindex="-1">
        Остановить
    </button>

    <table class="min-w-full divide-y divide-gray-200 mt-4">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="ext-left px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">
                PID
            </th>
            <th scope="col"
                class="ext-left px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">
                Процес
            </th>
        </tr>
        </thead>
        @if (is_null($game_process))
            <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                    Запусти игру...
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                </td>
            </tr>
            </tbody>
        @else
            @foreach($game_process as $item)
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col md:flex-row flex-wrap justify-center items-center gap-2">
                            <p class="text-gray-900">
                                {{data_get($item, 'pid')}}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col md:flex-row flex-wrap justify-center items-center gap-2">
                            <p class="text-green-500">{{data_get($item, 'process')}}</p>
                        </div>
                    </td>
                </tr>
                </tbody>
            @endforeach
        @endif

    </table>

</div>
