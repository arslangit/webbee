<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{

    /**
     * Returns workshops for an event
     * @return HasMany
     */
    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class);
    }

    public function latestWorkshop(): hasOne
    {
        return $this->hasOne(Workshop::class,'event_id')->orderBy('id','asc');
    }
}
