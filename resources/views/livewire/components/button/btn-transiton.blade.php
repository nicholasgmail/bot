<div class="btn button-group text-sm">

    <button type="button"
            wire:click="add({{data_get($this->transition, 'id')}})"
            class="btn_indigo">
        {{__('Движения')}}
    </button>
    <button type="button"
            wire:click="copy({{data_get($this->transition, 'id')}})"
            class="ml-2 btn_red">
        {{__('Копировать')}}
    </button>
    <button type="button"
            wire:click="delete({{data_get($this->transition, 'id')}})"
            class="ml-2 btn_red">
        {{__('Удалить')}}
    </button>
</div>
