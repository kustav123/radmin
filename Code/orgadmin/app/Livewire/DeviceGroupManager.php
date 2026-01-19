<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeviceGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DeviceGroupManager extends Component
{
    use WithPagination;

    public $search = '';
    public $name;
    public $deviceGroupId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
    ];

    public function render()
    {
        $deviceGroups = DeviceGroup::with('creator')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('group_code', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalGroups = DeviceGroup::count();
        $activeGroups = DeviceGroup::where('status', true)->count();
        $inactiveGroups = DeviceGroup::where('status', false)->count();

        return view('livewire.device-group-manager', [
            'deviceGroups' => $deviceGroups,
            'totalGroups' => $totalGroups,
            'activeGroups' => $activeGroups,
            'inactiveGroups' => $inactiveGroups,
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
        $this->deviceGroupId = null;
    }

    public function store()
    {
        $this->validate();

        if ($this->deviceGroupId) {
            $deviceGroup = DeviceGroup::find($this->deviceGroupId);
            $deviceGroup->update([
                'name' => $this->name,
            ]);
            $message = 'Device Group Updated Successfully.';
        } else {
            $groupCode = strtolower(Str::random(6));
            // Ensure uniqueness just in case
            while (DeviceGroup::where('group_code', $groupCode)->exists()) {
                $groupCode = strtolower(Str::random(6));
            }

            DeviceGroup::create([
                'name' => $this->name,
                'group_code' => $groupCode,
                'status' => true,
                'created_by' => Auth::id(),
            ]);
            $message = 'Device Group Created Successfully.';
        }

        session()->flash('message', $message);
        $this->closeModal();
    }

    public function edit($id)
    {
        $deviceGroup = DeviceGroup::findOrFail($id);
        $this->deviceGroupId = $id;
        $this->name = $deviceGroup->name;
        $this->openModal();
    }

    public function toggleStatus($id)
    {
        $deviceGroup = DeviceGroup::findOrFail($id);
        $deviceGroup->status = !$deviceGroup->status;
        $deviceGroup->save();
        session()->flash('message', 'Device Group Status Updated Successfully.');
    }

    public function delete($id)
    {
        DeviceGroup::find($id)->delete();
        session()->flash('message', 'Device Group Deleted Successfully.');
    }

    // Subgroup Management
    public $isSubgroupModalOpen = false;
    public $subgroupGroupId;
    public $subgroups = [];
    public $subgroupName;
    public $subgroupStatus = true;
    public $editingSubgroupIndex = null;
    
    // Delete Confirmation State
    public $deleteSubgroupIndex = null;
    public $showDeleteConfirmation = false;

    public function openSubgroupModal($id)
    {
        $group = DeviceGroup::findOrFail($id);
        $this->subgroupGroupId = $id;
        $this->subgroups = $group->subgroup ?? [];
        $this->isSubgroupModalOpen = true;
        $this->resetSubgroupInputs();
    }

    public function closeSubgroupModal()
    {
        $this->isSubgroupModalOpen = false;
        $this->subgroups = [];
        $this->subgroupGroupId = null;
        $this->showDeleteConfirmation = false;
        $this->deleteSubgroupIndex = null;
    }

    public function resetSubgroupInputs()
    {
        $this->subgroupName = '';
        $this->subgroupStatus = true;
        $this->editingSubgroupIndex = null;
    }

    public function saveSubgroup()
    {
        $this->validate([
            'subgroupName' => 'required|min:2|max:255',
        ]);

        $subgroupData = [
            'name' => $this->subgroupName,
            'status' => (bool)$this->subgroupStatus,
            'created_by' => Auth::id(),
            'created_at' => now()->toDateTimeString(),
        ];

        $group = DeviceGroup::findOrFail($this->subgroupGroupId);
        
        if ($this->editingSubgroupIndex !== null) {
            $existing = $this->subgroups[$this->editingSubgroupIndex];
            $subgroupData['created_by'] = $existing['created_by'] ?? Auth::id();
            $subgroupData['created_at'] = $existing['created_at'] ?? now()->toDateTimeString();
            $subgroupData['id'] = $existing['id'] ?? (string) Str::uuid();
            
            $this->subgroups[$this->editingSubgroupIndex] = $subgroupData;
            $msg = 'Subgroup updated successfully.';
        } else {
            $subgroupData['id'] = (string) Str::uuid();
            $this->subgroups[] = $subgroupData;
            $msg = 'Subgroup added successfully.';
        }

        $group->subgroup = $this->subgroups;
        $group->save();
        
        $this->resetSubgroupInputs();
        session()->flash('message', $msg);
    }

    public function editSubgroup($index)
    {
        $this->editingSubgroupIndex = $index;
        $subgroup = $this->subgroups[$index];
        $this->subgroupName = $subgroup['name'];
        $this->subgroupStatus = $subgroup['status'] ?? true;
    }

    public function confirmDeleteSubgroup($index)
    {
        $this->deleteSubgroupIndex = $index;
        $this->showDeleteConfirmation = true;
    }

    public function deleteConfirmed()
    {
        if ($this->deleteSubgroupIndex !== null && isset($this->subgroups[$this->deleteSubgroupIndex])) {
            $this->deleteSubgroup($this->deleteSubgroupIndex);
            $this->showDeleteConfirmation = false;
            $this->deleteSubgroupIndex = null;
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->deleteSubgroupIndex = null;
    }

    public function deleteSubgroup($index)
    {
        unset($this->subgroups[$index]);
        $this->subgroups = array_values($this->subgroups);
        
        $group = DeviceGroup::findOrFail($this->subgroupGroupId);
        $group->subgroup = $this->subgroups;
        $group->save();
        
        session()->flash('message', 'Subgroup deleted successfully.');
    }

    public function toggleSubgroupStatus($index)
    {
        $currentStatus = $this->subgroups[$index]['status'] ?? true;
        $this->subgroups[$index]['status'] = !$currentStatus;
        
        $group = DeviceGroup::findOrFail($this->subgroupGroupId);
        $group->subgroup = $this->subgroups;
        $group->save();
        
        session()->flash('message', 'Subgroup status updated successfully.');
    }
}
