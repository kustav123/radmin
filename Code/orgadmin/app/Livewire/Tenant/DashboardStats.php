<?php

namespace App\Livewire\Tenant;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class DashboardStats extends Component
{
    public function render()
    {
        return view('livewire.tenant.dashboard-stats', [
            'userCount' => User::count(),
            'roleCount' => Role::count(),
        ]);
    }
}
