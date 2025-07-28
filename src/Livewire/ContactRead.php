<?php

namespace Darvis\MantaContact\Livewire;

use Livewire\Component;
use Darvis\MantaContact\Models\Contact;
use Darvis\MantaContact\Traits\ContactTrait;
use Illuminate\Http\Request;
use Manta\FluxCMS\Traits\MantaTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class ContactRead extends Component
{
    use MantaTrait;
    use ContactTrait;

    public function mount(Request $request, Contact $contact)
    {
        $this->item = $contact;
        $this->itemOrg = $contact;
        $this->locale = $contact->locale;

        if ($contact) {
            $this->id = $contact->id;
        }


        $this->getLocaleInfo();
        $this->getBreadcrumb('read');

        $this->getTablist();
    }


    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-read')->layoutData(['title' => $this->config['module_name']['single'] . ' bekijken']);
    }
}
