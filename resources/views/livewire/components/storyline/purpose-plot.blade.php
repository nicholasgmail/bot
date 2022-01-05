<div class="flex-auto">
    <p>Имя</p>
    <div class="max-w-xs me-auto">
        <input wire:model="purpose_plot" class="{{$classes}}">

        @if($errors->has('name'))
            @error('purpose_plot') <span class="font-bold text-red-500">{{ $message }}</span> @enderror
        @endif
    </div>
</div>
