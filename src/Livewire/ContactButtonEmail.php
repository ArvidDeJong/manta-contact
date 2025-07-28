<?php

namespace Darvis\MantaContact\Livewire;

use Darvis\MantaContact\Models\Contact;
use Livewire\Component;

class ContactButtonEmail extends Component
{
    public ?Contact $contact = null;

    public bool $send = false;

    public function render()
    {
        return view('manta-contact::livewire.manta.contact.contact-button-email');
    }

    public function save()
    {
        $this->send = false;

        $this->contact->sendmail();
    }
}
