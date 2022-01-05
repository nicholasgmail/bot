<div>
    <h4 class="text-red-300 text-2xl font-bold">{{$category->name}}</h4>
    <div class="flex flex-row flex-wrap justify-start text-sm">
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Займ вывод через цикл</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$loan</span></p>
            @foreach($loan as $key=>$item)
                <p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p>
            @endforeach
        </div>
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Кредит вывод через цикл</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$credit</span></p>
            @foreach($credit as $key=>$item)
                <p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p>
            @endforeach
        </div>
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Актив вывод через цикл</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$active</span></p>
            @foreach($active as $key=>$item)
                <p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p>
            @endforeach
        </div>
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Пасив вывод через цикл</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$expenses</span></p>
            @foreach($expenses as $key=>$item)
                <p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p>
            @endforeach
        </div>
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Доход вывод через цикл</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$clients</span></p>
            @foreach($clients as $key=>$item)
                <p>{{$key}} : <span class="text-yellow-300 font-bold">{{$item}}</span></p>
            @endforeach
        </div>
        <div class="w-2/5 border border-white p-2 mt-3">
            <h5>Стартовый капитал</h5>
            <p>endpoint : <span class="text-yellow-300 font-bold">$balance_a</span></p>
            <p><span class="text-yellow-300 font-bold">{{$balance_a}}</span></p>
        </div>
    </div>
</div>
