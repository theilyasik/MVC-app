<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price_cents', 'duration_minutes', 'is_active',
    ];

    public function sessions(): BelongsToMany
    {
        // связь many-to-many через provided_services
        return $this->belongsToMany(Session::class, 'provided_services', 'service_id', 'session_id')
            ->withPivot(['quantity', 'unit_price_cents'])
            ->withTimestamps();
    }
}
