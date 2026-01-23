<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrganizationCrud extends Component
{
    public $show = false;
    public $organizationId;
    public $name;

    protected $listeners = [
        'openOrganizationCrud' => 'open',
    ];

    protected $rules = [
        'name' => 'required|min:3|max:255',
    ];

    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset();

        $this->organizationId = $id;

        if ($id) {
            $organization = Organization::findOrFail($id);
            $this->name = $organization->name;
        }

        $this->show = true;
    }

    public function close()
    {
        $this->reset();
    }

    public function save()
    {
        $this->validate();

        if ($this->organizationId) {
            $organization = Organization::find($this->organizationId);
            $organization->update([
                'name' => $this->name,
            ]);
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
        }

        $this->close();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Organization saved successfully',
        ]);

        $this->dispatch('organizationSaved');
    }

    public function render()
    {
        return view('livewire.organization.organization-crud');
    }
}
