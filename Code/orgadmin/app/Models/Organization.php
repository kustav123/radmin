<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'org_code',
        'name',
        'status',
        'created_by',
        'department',
    ];

    protected $casts = [
        'department' => 'array',
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
