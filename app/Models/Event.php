<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

    public function duty(): BelongsTo
    {
        return $this->BelongsTo(Duty::class, 'duty_id');
    }

    public function responsiblePerson(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }
}
