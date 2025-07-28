<?php

namespace Darvis\MantaContact\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Darvis\MantaContact\Models\Option;
use Darvis\MantaContact\Traits\ContactTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class ContactSettings extends Component
{
    use MantaTrait;
    use ContactTrait;

    public array $settingsArr = [];
    public array $settings = [];
    public array $emailcodes = [];

    public function mount(Request $request)
    {

        $this->getBreadcrumb('settings');

        $this->locale = getLocaleManta();
        if ($request->input('locale')) {
            $this->locale = $request->input('locale');
        }
        $this->getSettings();

        $this->getTablistSettings();

        $this->settings = $this->config['settings'];
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-settings')->layoutData(['title' => $this->config['module_name']['single'] . ' instellingen']);
    }
}
