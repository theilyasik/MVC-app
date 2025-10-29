<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'client_id', 'cosmetologist_id', 'starts_at', 'ends_at',
        'room', 'status', 'notes',
    ];

    public $timestamps = true;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function cosmetologist(): BelongsTo
    {
        return $this->belongsTo(Cosmetologist::class, 'cosmetologist_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'provided_services', 'session_id', 'service_id')
            ->withPivot(['quantity', 'unit_price_cents'])
            ->withTimestamps();
    }
}
