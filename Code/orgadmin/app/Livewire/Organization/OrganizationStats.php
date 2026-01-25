<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;


class OrganizationStats extends Component
{
    protected $listeners = [
        'organizationSaved' => '$refresh',
        'organizationStatusToggled' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.organization.organization-stats', [
            'total' => Organization::count(),
            'active' => Organization::where('status', true)->count(),
            'inactive' => Organization::where('status', false)->count(),
        ]);
    }
}
