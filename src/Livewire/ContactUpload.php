<?php

namespace Darvis\MantaContact\Livewire;

use Darvis\MantaContact\Models\Contact;
use Darvis\MantaContact\Traits\ContactTrait;
use Illuminate\Http\Request;
use Manta\FluxCMS\Traits\MantaTrait;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class ContactUpload extends Component
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
        $this->getBreadcrumb('upload');
        $this->getTablist();
    }

    public function render()
    {
        return view('manta-contact::livewire.manta.default.manta-default-upload')->layoutData(['title' => $this->config['module_name']['single'] . ' bestanden']);
    }
}
