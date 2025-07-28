<?php

namespace Darvis\MantaContact\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Darvis\MantaContact\Models\Contact;
use Darvis\MantaContact\Traits\ContactTrait;
use Faker\Factory as Faker;
use Manta\FluxCMS\Traits\MantaTrait;
use Manta\FluxCMS\Traits\WithSortingTrait;

#[Layout('manta-cms::layouts.app')]
class ContactCreate extends Component
{
    use ContactTrait;
    use MantaTrait;

    public function mount()
    {

        if (class_exists(Faker::class) && config('app.env') === 'local') {
            $faker = Faker::create('nl_NL');  // Nederlandse locale voor realistische gegevens

            // Veld met gegenereerde fake data
            $this->company = $faker->company;  // Een willekeurige bedrijfsnaam
            $this->title = $faker->jobTitle;  // Een willekeurige functietitel
            $this->sex = $faker->randomElement(['male', 'female']);  // Geslacht, 'male' of 'female'
            $this->firstname = $faker->firstName;  // Een willekeurige voornaam
            $this->lastname = $faker->lastName;  // Een willekeurige achternaam
            $this->name = $faker->name;  // Een willekeurige volledige naam
            $this->email = $faker->unique()->safeEmail;  // Een uniek en veilig e-mailadres
            $this->phone = $faker->phoneNumber;  // Een willekeurig telefoonnummer
            $this->address = $faker->streetAddress;  // Een willekeurig straatadres
            $this->zipcode = $faker->postcode;  // Een Nederlandse postcode
            $this->city = $faker->city;  // Een willekeurige stad
            $this->country = $faker->country;  // Een willekeurig land
            $this->birthdate = Carbon::parse($faker->date('Y-m-d', '2000-01-01'))->format('Y-m-d');  // Geboortedatum vóór 2000
            $this->newsletters = $faker->boolean;  // Willekeurig true of false voor nieuwsbrief
            $this->subject = $faker->sentence(5);  // Een korte zin als onderwerp
            $this->comment = $faker->paragraph(3);  // Een willekeurige alinea als commentaar
            $this->internal_contact = $faker->boolean;  // Willekeurig true of false voor interne contactpersoon
            $this->ip = $faker->ipv4;  // Een willekeurig IPv4-adres
        }

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('create');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-create')->layoutData(['title' => $this->config['module_name']['single'] . ' toevoegen']);
    }


    public function save()
    {
        $this->validate();

        $row = $this->only(
            'locale',
            'company',
            'title',
            'sex',
            'firstname',
            'lastname',
            'name',
            'email',
            'phone',
            'address',
            'address_nr',
            'zipcode',
            'city',
            'country',
            'birthdate',
            'newsletters',
            'subject',
            'comment',
            'internal_contact',
            'ip',
            'comment_client',
            'comment_internal',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
            'option_5',
            'option_6',
            'option_7',
            'option_8',
        );
        $row['created_by'] = auth('staff')->user()->name;
        Contact::create($row);
        // $this->toastr('success', 'Contact toegevoegd');

        return $this->redirect(ContactList::class);
    }
}
