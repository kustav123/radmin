<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'migration_path',
        'seeder_class',
        'version',
        'is_active',
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_modules')
                    ->withPivot(['is_enabled', 'is_installed', 'installed_at'])
                    ->withTimestamps();
    }
}
