<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = ['name', 'price_cents', 'duration_minutes', 'is_active'];

    public $timestamps = true;

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'provided_services', 'service_id', 'session_id')
            ->withPivot(['quantity', 'unit_price_cents'])
            ->withTimestamps();
    }
}
