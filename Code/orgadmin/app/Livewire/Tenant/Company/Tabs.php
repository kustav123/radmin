<?php

namespace App\Livewire\Tenant\Company;

use Livewire\Component;

class Tabs extends Component
{
    public $tenant;

    public string $activeTab = 'general';

    protected $queryString = ['activeTab' => ['except' => 'general']];

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.tenant.company.tabs');
    }
}
