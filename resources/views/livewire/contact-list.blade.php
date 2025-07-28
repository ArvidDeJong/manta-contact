<flux:main container>
    <x-manta.breadcrumb :$breadcrumb />
    <div class="flex mt-4">
        <div class="flex-grow">
            {{-- <x-manta.buttons.large type="add" :href="route($this->route_name . '.create')" /> --}}

            @if (isset($config['settings']) && count($config['settings']) > 0)
                <x-manta.buttons.large type="gear" :href="route($this->route_name . '.settings')" />
            @endif

        </div>
        <div class="w-1/5">
            <x-manta.input.search />
        </div>
    </div>

    <x-manta.tables.tabs :$tablistShow :$trashed />
    <flux:table :paginate="$items">
        <flux:table.columns>
            @if (count(getLocalesManta()) > 1)
                <flux:table.column></flux:table.column>
            @endif
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                wire:click="dosort('created_at')">Toegevoegd</flux:table.column>
            @if ($fields['name']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                    wire:click="dosort('name')">
                    Naam</flux:table.column>
            @endif
            @if ($fields['firstname']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'firstname'" :direction="$sortDirection"
                    wire:click="dosort('firstname')">Voornaam</flux:table.column>
            @endif
            @if ($fields['lastname']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'lastname'" :direction="$sortDirection"
                    wire:click="dosort('lastname')">Achternaam</flux:table.column>
            @endif
            @if ($fields['email']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection"
                    wire:click="dosort('email')">Email</flux:table.column>
            @endif
            @if ($fields['phone']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'phone'" :direction="$sortDirection"
                    wire:click="dosort('phone')">Telefoon</flux:table.column>
            @endif

        </flux:table.columns>
        <flux:table.rows>
            @foreach ($items as $item)
                <flux:table.row data-id="{{ $item->id }}">
                    @if (count(getLocalesManta()) > 1)
                        <flux:table.cell><i class="fi fi-{{ $item->locale }}"></i></flux:table.cell>
                    @endif
                    <flux:table.cell>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                    </flux:table.cell>
                    @if ($fields['name']['active'])
                        <flux:table.cell>{{ $item->name }}</flux:table.cell>
                    @endif
                    @if ($fields['firstname']['active'])
                        <flux:table.cell>{{ $item->firstname }}</flux:table.cell>
                    @endif
                    @if ($fields['lastname']['active'])
                        <flux:table.cell>{{ $item->lastname }}</flux:table.cell>
                    @endif
                    @if ($fields['email']['active'])
                        <flux:table.cell><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></flux:table.cell>
                    @endif
                    @if ($fields['phone']['active'])
                        <flux:table.cell><a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></flux:table.cell>
                    @endif
                    <flux:table.cell>

                        <flux:button size="sm" href="{{ route($this->route_name . '.read', $item) }}"
                            icon="eye" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:main>
