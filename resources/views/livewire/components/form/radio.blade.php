
<div class="flex-initial w-auto">
    <div class="mt-1 mr-3">
        <label class="inline-flex items-center ">
            <input type="radio" wire:click="variant"
                   @if($context == $value) checked @endif
                   value="{{$value}}"
                   name="variant"
                   class="form-checkbox h-6 w-6 text-green-500">
            <span class="ml-1 sm:ml-2 text-sm sm:text-base">{{$option}}</span>
        </label>
    </div>
</div>
