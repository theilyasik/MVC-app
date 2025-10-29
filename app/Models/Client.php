<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'full_name', 'phone', 'email', 'notes',
    ];

    public $timestamps = true;

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'client_id');
    }
}
