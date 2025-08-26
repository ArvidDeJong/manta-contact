<?php

namespace Darvis\MantaContact\Traits;

use Darvis\MantaContact\Models\Contact;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Manta\FluxCMS\Models\MantaModule;
use Manta\FluxCMS\Services\ModuleSettingsService;

trait ContactTrait
{


    public function __construct()
    {
        $this->module_routes = [
            'name' => 'contact',
            'list' => 'contact.list',
            'create' => 'contact.create',
            'update' => 'contact.update',
            'read' => 'contact.read',
            'upload' => 'contact.upload',
            'settings' => 'contact.settings',
            'maps' => null,
        ];

        $settings = ModuleSettingsService::ensureModuleSettings('contact', "darvis/manta-contact");
        $this->config = $settings;

        $this->fields = $settings['fields'] ?? [];
        $this->tab_title = $settings['tab_title'] ?? null;
        $this->moduleClass = 'Darvis\MantaContact\Models\Contact';
    }

    public ?Contact $item = null;
    public ?Contact $itemOrg = null;

    #[Locked]
    public ?string $company_id = null;

    #[Locked]
    public ?string $host = null;

    public ?string $locale = 'nl';
    public ?string $company = null;
    public ?string $title = null;
    public ?string $sex = null;
    public ?string $firstname = null;
    public ?string $lastname = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $address_nr = null;
    public ?string $zipcode = null;
    public ?string $city = null;
    public ?string $country = null;
    public ?string $birthdate = null;
    public ?bool $newsletters = false;
    public ?string $subject = null;
    public ?string $comment = null;
    public ?string $internal_contact = null;
    public ?string $ip = null;
    public $option_1;
    public $option_2;
    public $option_3;
    public $option_4;
    public $option_5;
    public $option_6;
    public $option_7;
    public $option_8;

    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query->where(function (Builder $querysub) {
                $querysub->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('firstname', 'LIKE', "%{$this->search}%")
                    ->orWhere('lastname', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%")
                    ->orWhere('phone', 'LIKE', "%{$this->search}%")
                    ->orWhere('address', 'LIKE', "%{$this->search}%")
                    ->orWhere('zipcode', 'LIKE', "%{$this->search}%");
            });
    }

    public function rules()
    {
        $return = [];

        if ($this->fields['company']['active'] == true) {
            $return['company'] = $this->fields['company']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['title']['active'] == true) {
            $return['title'] = $this->fields['title']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['sex']['active'] == true) {
            $return['sex'] = $this->fields['sex']['required'] == true ? 'required|in:male,female' : 'nullable|in:male,female';
        }

        if ($this->fields['firstname']['active'] == true) {
            $return['firstname'] = $this->fields['firstname']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['lastname']['active'] == true) {
            $return['lastname'] = $this->fields['lastname']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['name']['active'] == true) {
            $return['name'] = $this->fields['name']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['email']['active'] == true) {
            $return['email'] = $this->fields['email']['required'] == true ? 'required|email|max:255' : 'nullable|email|max:255';
        }

        if ($this->fields['phone']['active'] == true) {
            $return['phone'] = $this->fields['phone']['required'] == true ? 'required|string|max:20' : 'nullable|string|max:20';
        }

        if ($this->fields['address']['active'] == true) {
            $return['address'] = $this->fields['address']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['zipcode']['active'] == true) {
            $return['zipcode'] = $this->fields['zipcode']['required'] == true ? 'required|string|max:10' : 'nullable|string|max:10';
        }

        if ($this->fields['city']['active'] == true) {
            $return['city'] = $this->fields['city']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['country']['active'] == true) {
            $return['country'] = $this->fields['country']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['birthdate']['active'] == true) {
            $return['birthdate'] = $this->fields['birthdate']['required'] == true ? 'required|date|before:today' : 'nullable|date|before:today';
        }

        if ($this->fields['newsletters']['active'] == true) {
            $return['newsletters'] = $this->fields['newsletters']['required'] == true ? 'required|boolean' : 'nullable|boolean';
        }

        if ($this->fields['subject']['active'] == true) {
            $return['subject'] = $this->fields['subject']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if ($this->fields['comment']['active'] == true) {
            $return['comment'] = $this->fields['comment']['required'] == true ? 'required|string|max:5000' : 'nullable|string|max:5000';
        }

        if ($this->fields['internal_contact']['active'] == true) {
            $return['internal_contact'] = $this->fields['internal_contact']['required'] == true ? 'required|boolean' : 'nullable|boolean';
        }

        if ($this->fields['ip']['active'] == true) {
            $return['ip'] = $this->fields['ip']['required'] == true ? 'required|ip' : 'nullable|ip';
        }

        return $return;
    }


    public function messages()
    {
        $return = [];

        // Foutmeldingen voor 'company'
        $return['company.required'] = 'De bedrijfsnaam is verplicht.';
        $return['company.string'] = 'De bedrijfsnaam moet een geldige tekst zijn.';
        $return['company.max'] = 'De bedrijfsnaam mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'title'
        $return['title.required'] = 'De functietitel is verplicht.';
        $return['title.string'] = 'De functietitel moet een geldige tekst zijn.';
        $return['title.max'] = 'De functietitel mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'sex'
        $return['sex.required'] = 'Het geslacht is verplicht.';
        $return['sex.in'] = 'Het geslacht moet male of female zijn.';

        // Foutmeldingen voor 'firstname'
        $return['firstname.required'] = 'De voornaam is verplicht.';
        $return['firstname.string'] = 'De voornaam moet een geldige tekst zijn.';
        $return['firstname.max'] = 'De voornaam mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'lastname'
        $return['lastname.required'] = 'De achternaam is verplicht.';
        $return['lastname.string'] = 'De achternaam moet een geldige tekst zijn.';
        $return['lastname.max'] = 'De achternaam mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'name'
        $return['name.required'] = 'De naam is verplicht.';
        $return['name.string'] = 'De naam moet een geldige tekst zijn.';
        $return['name.max'] = 'De naam mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'email'
        $return['email.required'] = 'Het e-mailadres is verplicht.';
        $return['email.email'] = 'Voer een geldig e-mailadres in.';
        $return['email.max'] = 'Het e-mailadres mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'phone'
        $return['phone.required'] = 'Het telefoonnummer is verplicht.';
        $return['phone.string'] = 'Het telefoonnummer moet een geldige tekst zijn.';
        $return['phone.max'] = 'Het telefoonnummer mag niet langer zijn dan 20 tekens.';

        // Foutmeldingen voor 'address'
        $return['address.required'] = 'Het adres is verplicht.';
        $return['address.string'] = 'Het adres moet een geldige tekst zijn.';
        $return['address.max'] = 'Het adres mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'zipcode'
        $return['zipcode.required'] = 'De postcode is verplicht.';
        $return['zipcode.string'] = 'De postcode moet een geldige tekst zijn.';
        $return['zipcode.max'] = 'De postcode mag niet langer zijn dan 10 tekens.';

        // Foutmeldingen voor 'city'
        $return['city.required'] = 'De stad is verplicht.';
        $return['city.string'] = 'De stad moet een geldige tekst zijn.';
        $return['city.max'] = 'De stad mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'country'
        $return['country.required'] = 'Het land is verplicht.';
        $return['country.string'] = 'Het land moet een geldige tekst zijn.';
        $return['country.max'] = 'Het land mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'birthdate'
        $return['birthdate.required'] = 'De geboortedatum is verplicht.';
        $return['birthdate.date'] = 'De geboortedatum moet een geldige datum zijn.';
        $return['birthdate.before'] = 'De geboortedatum moet in het verleden liggen.';

        // Foutmeldingen voor 'newsletters'
        $return['newsletters.required'] = 'Geef aan of nieuwsbrieven ontvangen moeten worden.';
        $return['newsletters.boolean'] = 'Het veld nieuwsbrieven moet waar of onwaar zijn.';

        // Foutmeldingen voor 'subject'
        $return['subject.required'] = 'Het onderwerp is verplicht.';
        $return['subject.string'] = 'Het onderwerp moet een geldige tekst zijn.';
        $return['subject.max'] = 'Het onderwerp mag niet langer zijn dan 255 tekens.';

        // Foutmeldingen voor 'comment'
        $return['comment.required'] = 'Het commentaar is verplicht.';
        $return['comment.string'] = 'Het commentaar moet een geldige tekst zijn.';
        $return['comment.max'] = 'Het commentaar mag niet langer zijn dan 5000 tekens.';

        // Foutmeldingen voor 'internal_contact'
        $return['internal_contact.required'] = 'Geef aan of er een interne contactpersoon is.';
        $return['internal_contact.boolean'] = 'Het veld interne contactpersoon moet waar of onwaar zijn.';

        // Foutmeldingen voor 'ip'
        $return['ip.required'] = 'Het IP-adres is verplicht.';
        $return['ip.ip'] = 'Voer een geldig IP-adres in.';

        return $return;
    }
}
