<span>
    @if ($send)
        Versturen?
        <button type="button" class="btn btn-sm btn-success" wire:click="save" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">Ja</span>
            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin"></i></span>
        </button>
        <button type="button" class="btn btn-sm btn-danger" wire:click="$set('send', false)">Nee</button>
    @else
        <button type="button" class="btn btn-sm btn-primary" wire:click="$set('send', true)"><i
                class="fa-solid fa-envelope"></i></button>
    @endif
</span>
