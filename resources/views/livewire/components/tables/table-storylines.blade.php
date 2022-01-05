<div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="ext-left px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider">
                Контекст
            </th>
        </tr>
        </thead>
        @foreach($storylines as $item)
            <tbody class="bg-white divide-y divide-gray-200">

            @if(is_null($item))
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Не содержит сообщений...
                    </td>
                </tr>
            @else
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col md:flex-row flex-wrap justify-center items-center gap-2">
                            <div class="flex-1 self-center">
                                <div class="text-sm font-medium text-gray-900">
                                    {{data_get($item, 'name')}}
                                </div>
                            </div>
                            <div class="self-center">
                                <button wire:click="select({{data_get($item, 'id')}})"
                                        class="py-2 px-4 bg-green-700 text-white font-semibold rounded-lg shadow-md hover:bg-cyan-900 focus:outline-none"
                                        tabindex="-1">
                                    Выбрать
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
            <!-- More people... -->
            </tbody>
        @endforeach
    </table>

</div>
