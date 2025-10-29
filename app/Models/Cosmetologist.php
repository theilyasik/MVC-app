<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cosmetologist extends Model
{
    protected $table = 'cosmetologists';

    protected $fillable = ['full_name'];

    public $timestamps = true;

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'cosmetologist_id');
    }
}
