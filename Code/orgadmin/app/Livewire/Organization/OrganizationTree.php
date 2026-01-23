<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Department;


class OrganizationTree extends Component
{
    public $tree = [];
    public array $expanded = [];

    protected $listeners = [
        'refreshOrganizationTree' => 'loadTree',
    ];

    public function mount()
    {
        $this->loadTree();
    }

    public function loadTree()
    {
        $this->tree = Organization::select('id', 'name', 'org_code', 'department', 'status')->orderBy('name')->get();
    }

    public function toggle($id)
    {
        $this->expanded[$id] = !($this->expanded[$id] ?? false);
    }

    public function select($id)
    {
        $this->dispatch('organizationSelected', id: $id);
    }

    public function render()
    {
        return view('livewire.organization.organization-tree');
    }
}
