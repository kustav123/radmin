<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Illuminate\Support\Str;

class Organization extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $table = 'organizations';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'plan',
        'features',
        'status',
        'created_by',
        'department',
        'data',
    ];

    protected static function booted()
    {
        static::creating(function ($organization) {
            $originalSlug = Str::slug($organization->name);
            $slug = $originalSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }

            $organization->slug = $slug;
        });
    }
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'status',
            'created_by',
            'department',
            'slug',
            'plan',
            'features',
        ];
    }

    protected $casts = [
        'department' => 'array',
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
