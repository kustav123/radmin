<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceGroup extends Model
{
    protected $fillable = [
        'group_code',
        'name',
        'status',
        'created_by',
        'subgroup',
    ];

    protected $casts = [
        'subgroup' => 'array',
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
