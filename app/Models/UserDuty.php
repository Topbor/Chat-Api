<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDuty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'duty_id',
        'started'
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function duty(): BelongsTo
    {
        return $this->BelongsTo(Duty::class);
    }
}
