<?php

namespace App\Livewire\Organization\Tabs;

use Livewire\Component;
use App\Models\Organization;

class Profile extends Component
{
    public Organization $organization;

    public function render()
    {
        return view('livewire.organization.tabs.profile', [
            'organization' => $this->organization,
        ]);
    }
}
