<?php

namespace App\Livewire\Organization;

use Livewire\Component;

class OrganizationCrud extends Component
{
     public $show = false;

    protected $listeners = [
        'openDepartmentCrud' => 'open',
    ];

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->reset();
    }

    public function save()
    {
        // validate + save
        $this->close();
        $this->dispatch('departmentSaved');
    }
    
    public function render()
    {
        return view('livewire.organization.organization-crud');
    }
}
