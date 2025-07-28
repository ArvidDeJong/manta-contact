<flux:main container>
    <x-manta.breadcrumb :$breadcrumb />
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Ontvangers</flux:label>
                <flux:textarea wire:model.blur="CONTACT_RECEIVERS" rows="auto" />
                <flux:error name="CONTACT_RECEIVERS" />
                <flux:description>Ook versturen naar de zender? Gebruik: ##ZENDER##</flux:description>
            </flux:field>
            <ul class="mt-8 list-disc pl-5">
                @foreach (explode(PHP_EOL, $CONTACT_RECEIVERS) as $key => $value)
                    <li class="flex items-center">
                        {!! filter_var($value, FILTER_VALIDATE_EMAIL) || $value == '##ZENDER##'
                            ? '<i class="mr-2 text-green-600 fa-solid fa-check"></i>'
                            : '<i class="mr-2 text-red-600 fa-solid fa-xmark"></i>' !!} <flux:subheading>{{ $value }}</flux:subheading>
                    </li>
                @endforeach
            </ul>
        </div>

        <flux:button type="submit" variant="primary" class="mt-8">Opslaan</flux:button>
        {{-- <div class="mt-6" wire:ignore>
            <label for="map" class="block mb-2 text-sm font-bold"></label>
            <div class="w-full h-96">
                <div id="map" class="w-full h-full"></div>
            </div>
        </div> --}}
    </form>
</flux:main>
