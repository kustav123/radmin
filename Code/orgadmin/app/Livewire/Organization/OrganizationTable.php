<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class OrganizationTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = [
        'organizationSaved' => '$refresh',
    ];

    public function toggleStatus($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->status = !$organization->status;
        $organization->save();
        session()->flash('message', 'Organization Status Updated Successfully.');
    }

    public function edit($id)
    {
        $this->dispatch('openOrganizationCrud', $id);
    }


    public function render()
    {
        $organizations = Organization::query()
            ->when($this->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('livewire.organization.organization-table', compact('organizations'));
    }
}
