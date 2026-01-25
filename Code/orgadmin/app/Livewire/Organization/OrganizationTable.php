<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;

class OrganizationTable extends Component
{
    use WithPagination;

    public $search = '';
    public $isLoading = false;

    protected $listeners = [
        'organizationSaved' => '$refresh',
    ];


    public function updatedSearch()
    {
        $this->isLoading = true;
        $this->resetPage();
    }


    public function updatingPage()
    {
        $this->isLoading = true;
    }

    public function toggleStatus($id)
    {
        $this->isLoading = true;
        $organization = Organization::findOrFail($id);
        $organization->status = !$organization->status;
        $organization->save();
        $this->dispatch('organizationStatusToggled');
        $this->isLoading = false;
    }

    public function edit($id)
    {
        $this->dispatch('openOrganizationCrud', $id);
    }

    public function render()
    {
        $this->isLoading = false;

        $organizations = Organization::query()
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%")
                        ->orWhere('id', 'ILIKE', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.organization.organization-table', compact('organizations'));
    }
}
