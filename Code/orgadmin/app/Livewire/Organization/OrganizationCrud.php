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
    public $disabled = false;

    protected $listeners = [
        'openOrganizationCrud' => 'open',
    ];

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'organizationId' => 'nullable', // or some validation for ID if manual
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
        $this->dispatch('loader-show');
        
        $this->validate();

        if ($this->organizationId) {
            $organization = Organization::findOrFail($this->organizationId);

            $organization->update([
                'name' => $this->name,
            ]);
        } else {

            $tenantId = strtolower(Str::random(6));
            while (Organization::find($tenantId)) {
                $tenantId = strtolower(Str::random(6));
            }

            $org = Organization::create([
                'id' => $tenantId,          
                'name' => $this->name,      
                'status' => true,
                'created_by' => Auth::id(),
            ]);

            $domain = $org->slug . '.localhost';
            $org->createDomain($domain);
        }

        $this->close();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Organization saved successfully',
        ]);

        $this->dispatch('loader-hide');
        $this->dispatch('organizationSaved');
    }

    public function render()
    {
        return view('livewire.organization.organization-crud');
    }
}
