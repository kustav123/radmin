<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;

class OrganizationTabs extends Component
{
    public Organization $organization;

    public string $activeTab = 'profile';

    protected $queryString = ['activeTab' => ['except' => 'profile']];

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.organization.organization-tabs');
    }
}
