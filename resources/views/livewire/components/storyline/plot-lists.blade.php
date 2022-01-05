@php
    $title = 'Уровни сложности'
@endphp
<div>
    <div class="flex flex-row flex-wrap justify-evenly">
        <div class="flex-auto lg:w-1/6 mr-3">
            <label for="exclude">Не показывать если были номера сюжетов:</label>
            <input wire:model="exclude" type="text" class="{{$classes}}">
        </div>
        <div class="flex-auto lg:w-1/6 mr-3">
            <label for="show">Показывать только если были номера сюжетов:</label>
            <input wire:model="show" type="text" class="{{$classes}}">
        </div>
        <div class="flex-auto lg:w-1/6 mr-3">
            <label for="name">Показывать только если есть в наличии имя:</label>
            <input wire:model="name" type="text" class="{{$classes}}">
        </div>
        <div class="flex-auto lg:w-1/6 mr-3">
            <label for="from_what">Показывать с какого номера игры:</label>
            <input wire:model="from_what" type="text" class="{{$classes}}">
        </div>
        <div class="flex-auto lg:w-1/6 mr-3">
            <label for="up_to_what">Показывать до какого номера игры:</label>
            <input wire:model="up_to_what" type="text" class="{{$classes}}">
        </div>
    </div>
</div>
