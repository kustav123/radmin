<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrganizationManager extends Component
{
    use WithPagination;

    public $search = '';
    public $name;
    public $organizationId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
    ];

    public function render()
    {
        $organizations = Organization::with('creator')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('org_code', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalOrgs = Organization::count();
        $activeOrgs = Organization::where('status', true)->count();
        $inactiveOrgs = Organization::where('status', false)->count();

        return view('livewire.organization-manager', [
            'organizations' => $organizations,
            'totalOrgs' => $totalOrgs,
            'activeOrgs' => $activeOrgs,
            'inactiveOrgs' => $inactiveOrgs,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->organizationId = null;
    }

    public function store()
    {
        $this->validate();

        if ($this->organizationId) {
            $organization = Organization::find($this->organizationId);
            $organization->update([
                'name' => $this->name,
            ]);
            $message = 'Organization Updated Successfully.';
        } else {
            $orgCode = strtolower(Str::random(6));
            // Ensure uniqueness just in case
            while (Organization::where('org_code', $orgCode)->exists()) {
                $orgCode = strtolower(Str::random(6));
            }

            Organization::create([
                'name' => $this->name,
                'org_code' => $orgCode,
                'status' => true,
                'created_by' => Auth::id(),
            ]);
            $message = 'Organization Created Successfully.';
        }

        session()->flash('message', $message);
        $this->closeModal();
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        $this->organizationId = $id;
        $this->name = $organization->name;
        $this->openModal();
    }

    public function toggleStatus($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->status = !$organization->status;
        $organization->save();
        session()->flash('message', 'Organization Status Updated Successfully.');
    }

    public function delete($id)
    {
        Organization::find($id)->delete();
        session()->flash('message', 'Organization Deleted Successfully.');
    }
}
