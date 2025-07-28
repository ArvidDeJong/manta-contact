<?php

namespace Darvis\MantaContact\Livewire;

use Livewire\Component;
use Darvis\MantaContact\Models\Contact;
use Livewire\WithPagination;
use Manta\FluxCMS\Traits\MantaTrait;
use Manta\FluxCMS\Traits\SortableTrait;
use Manta\FluxCMS\Traits\WithSortingTrait;
use Livewire\Attributes\Layout;
use Darvis\MantaContact\Traits\ContactTrait;

#[Layout('manta-cms::layouts.app')]
class ContactList extends Component
{
    use ContactTrait;
    use WithPagination;
    use SortableTrait;
    use MantaTrait;
    use WithSortingTrait;

    public function mount()
    {
        $this->sortBy = 'created_at';
        $this->sortDirection = 'DESC';


        $this->getBreadcrumb();
    }

    public function render()
    {
        $this->trashed = count(Contact::whereNull('pid')->onlyTrashed()->get());

        $obj = Contact::whereNull('pid');
        if ($this->tablistShow == 'trashed') {
            $obj->onlyTrashed();
        }
        $obj = $this->applySorting($obj);
        $obj = $this->applySearch($obj);
        $items = $obj->paginate(50);
        return view('manta-contact::livewire.contact-list', ['items' => $items])->layoutData(['title' => $this->config['module_name']['multiple']]);
    }
}
