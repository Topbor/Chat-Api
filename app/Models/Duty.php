<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Duty extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'duration',
        'beginning_at'
    ];

    protected $casts = [
        'beginning_at' => 'datetime',
    ];

    protected $appends = ['place_name'];

    public function place(): BelongsTo
    {
        return $this->BelongsTo(Place::class);
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'user_duties');
    }

    public function getPlaceNameAttribute() {
        return Place::find($this->place_id)->name;
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'duty_id');
    }

}
