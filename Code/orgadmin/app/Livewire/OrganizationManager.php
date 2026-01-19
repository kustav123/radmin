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

    // Department Management
    public $isDeptModalOpen = false;
    public $deptOrgId;
    public $departments = [];
    public $deptName;
    public $deptStatus = true;
    public $editingDeptIndex = null;
    
    // Delete Confirmation State
    public $deleteDeptIndex = null;
    public $showDeleteConfirmation = false;

    public function openDeptModal($id)
    {
        $org = Organization::findOrFail($id);
        $this->deptOrgId = $id;
        $this->departments = $org->department ?? [];
        $this->isDeptModalOpen = true;
        $this->resetDeptInputs();
    }

    public function closeDeptModal()
    {
        $this->isDeptModalOpen = false;
        $this->departments = [];
        $this->deptOrgId = null;
        $this->showDeleteConfirmation = false;
        $this->deleteDeptIndex = null;
    }

    public function resetDeptInputs()
    {
        $this->deptName = '';
        $this->deptStatus = true;
        $this->editingDeptIndex = null;
    }

    public function saveDepartment()
    {
        $this->validate([
            'deptName' => 'required|min:2|max:255',
        ]);

        $deptData = [
            'name' => $this->deptName,
            'status' => (bool)$this->deptStatus,
            'created_by' => Auth::id(),
            'created_at' => now()->toDateTimeString(),
        ];

        $org = Organization::findOrFail($this->deptOrgId);
        
        if ($this->editingDeptIndex !== null) {
            $existing = $this->departments[$this->editingDeptIndex];
            $deptData['created_by'] = $existing['created_by'] ?? Auth::id();
            $deptData['created_at'] = $existing['created_at'] ?? now()->toDateTimeString();
            $deptData['id'] = $existing['id'] ?? (string) Str::uuid();
            
            $this->departments[$this->editingDeptIndex] = $deptData;
            $msg = 'Department updated successfully.';
        } else {
            $deptData['id'] = (string) Str::uuid();
            $this->departments[] = $deptData;
            $msg = 'Department added successfully.';
        }

        $org->department = $this->departments;
        $org->save();
        
        $this->resetDeptInputs();
        session()->flash('message', $msg);
    }

    public function editDepartment($index)
    {
        $this->editingDeptIndex = $index;
        $dept = $this->departments[$index];
        $this->deptName = $dept['name'];
        $this->deptStatus = $dept['status'] ?? true;
    }

    public function confirmDeleteDepartment($index)
    {
        $this->deleteDeptIndex = $index;
        $this->showDeleteConfirmation = true;
    }

    public function deleteConfirmed()
    {
        if ($this->deleteDeptIndex !== null && isset($this->departments[$this->deleteDeptIndex])) {
            $this->deleteDepartment($this->deleteDeptIndex);
            $this->showDeleteConfirmation = false;
            $this->deleteDeptIndex = null;
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteDeptIndex = null;
    }

    public function deleteDepartment($index)
    {
        unset($this->departments[$index]);
        $this->departments = array_values($this->departments);
        
        $org = Organization::findOrFail($this->deptOrgId);
        $org->department = $this->departments;
        $org->save();
        
        session()->flash('message', 'Department deleted successfully.');
    }

    public function toggleDeptStatus($index)
    {
        // Ensure the status key exists and toggle it. 
        // Using strict comparison for safety, defaulting to true if missing (though it should be presumably true on creation)
        $currentStatus = $this->departments[$index]['status'] ?? true;
        $this->departments[$index]['status'] = !$currentStatus;
        
        $org = Organization::findOrFail($this->deptOrgId);
        $org->department = $this->departments;
        $org->save();
        
        session()->flash('message', 'Department status updated successfully.');
    }
}
