<?php

namespace App\Livewire\Organization\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;
use App\Models\Module;


class Store extends Component
{
    public $organization;
    public $modules;
    
    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->modules = Module::all();
    }

    public function render()
    {
        return view('livewire.organization.tabs.store' , [
            'organization' => $this->organization,
            'modules' => $this->modules,
        ]);
    }
}
