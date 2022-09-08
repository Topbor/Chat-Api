<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chat extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

    public function messages()
    {
        return $this->HasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'chat_user',
            'chat_id',
            'user_id'
        );
    }

    public function duty()
    {
        return $this->BelongsTo(Duty::class);
    }
}
