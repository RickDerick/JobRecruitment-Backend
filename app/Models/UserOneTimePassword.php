<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UserOneTimePassword extends BaseModel
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
