<div class="border border-cyan-600 rounded p-4 mb-4 relative">
    <div class="flex flex-col md:flex-row justify-between gap-3 sm:gap-3 flex-wrap items-baseline">
        <div class="flex-2">
            <livewire:components.form.edit-transition :transition="$transition"/>
        </div>
        <div class="flex-1 self-center text-sm">
            <livewire:components.card.info-transiton :transition="$transition"/>
        </div>
        <div class="flex-1 self-center">
            <livewire:components.button.btn-transiton :transition="$transition"/>
        </div>
    </div>
</div>
