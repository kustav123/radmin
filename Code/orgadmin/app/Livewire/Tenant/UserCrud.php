<?php

namespace App\Livewire\Tenant;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCrud extends Component
{
    use WithPagination;

    public $showModal = false;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $selectedRoles = [];

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'selectedRoles' => 'array',
    ];

    public function render()
    {
        return view('livewire.tenant.user-crud', [
            'users' => User::with('roles')->paginate(10),
            'roles' => Role::all(),
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
        $this->userId = $id;
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $this->validate([
                'name' => 'required|min:3',
                'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
                'password' => 'nullable|min:8',
            ]);

            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);
            $user->syncRoles($this->selectedRoles);
        } else {
            $this->validate();
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $user->syncRoles($this->selectedRoles);
        }

        $this->showModal = false;
        $this->reset();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }
}
