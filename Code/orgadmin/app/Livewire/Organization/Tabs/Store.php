<?php

namespace App\Livewire\Organization\Tabs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;
use App\Models\Module;


class Store extends Component
{
    public Organization $organization;
    public $modules;
    public $assignedModules;

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->modules = Module::all();
        $this->assignedModules = $organization->modules()->pluck('modules.id')->toArray();
    }

    public function assignModule($moduleId)
    {
        $this->organization->modules()->attach($moduleId);
        $this->assignedModules[] = $moduleId;
    }

    public function unassignModule($moduleId)
    {
        $this->organization->modules()->detach($moduleId);
        $this->assignedModules = array_filter($this->assignedModules, fn($id) => $id != $moduleId);
    }

    public function render()
    {
        return view('livewire.organization.tabs.store', [
            'modules' => $this->modules,
            'assignedModules' => $this->assignedModules,
        ]);
    }
}
