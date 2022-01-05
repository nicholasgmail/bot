<div>
    @php
        $classes = 'block appearance-none bg-white placeholder-gray-600 border border-yellow-200 rounded w-full py-3 px-4 text-gray-700 leading-5 focus:outline-none focus:border-yellow-500 focus:placeholder-gray-400 focus:ring-2 focus:ring-rose-300'
    @endphp

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-brown text-white px-4 py-4">
                    <form wire:submit.prevent="updCategory" enctype="multipart/form-data">
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <div class="flex-initial">
                                <div class="inline-block pt-2 mb-4 w-full">
                                    <label for="name">Заголовок</label>
                                    <input wire:model="name" id="name" name="name" type="text" required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                </div>
                            </div>
                            <div class="flex-initial">
                                <div class="inline-block pt-2 mb-4 w-full">
                                    <label for="cell_number">Номера ячеек</label>
                                    <input wire:model="cell_number" id="cell_number" name="cell_number" type="text"
                                           required
                                           class="relative block w-full px-3 py-2 border
                                        border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    <p class="text-sm">пример '1,2,3,6'</p>
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
