<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCrud extends Component
{
    use WithPagination;

    public $showModal = false;
    public $roleId;
    public $name;
    public $startPage = 1;
    public $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|min:3',
        'selectedPermissions' => 'array',
    ];

    public function render()
    {
        return view('livewire.tenant.role-crud', [
            'roles' => Role::with('permissions')->paginate(10),
            'permissions' => Permission::all(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->reset();
        $this->roleId = $id;
        $role = Role::findOrFail($id);
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
        } else {
            $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);
            $role->syncPermissions($this->selectedPermissions);
        }

        $this->showModal = false;
        $this->reset();
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
    }
}
