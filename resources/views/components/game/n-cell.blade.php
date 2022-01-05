@props(['open'])

<div class="flex flex-wrap justify-between" style="flex-direction: column; height: 100%">
    <div class="flex-1">
        Настрой ячейку № {{$slot}}
        <div class="flex-1">
            <x-game.n-tab/>
        </div>
        <div class="flex-auto mt-4">
            <button @click="open = !open"
                    style="background-color:#507383; width: 40%; text-align: center;"
                    class="py-2 px-4 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                    tabindex="-1">
                Сохранить
            </button>
            <button
                    style="background-color:#507383; width: 40%; text-align: center;"
                    class="ml-1 py-2 px-4 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-900 focus:outline-none"
                    tabindex="-1">
                Добавить
            </button>
        </div>
    </div>
</div>
