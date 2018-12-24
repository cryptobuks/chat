<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserFriends extends Pivot
{
    /**
     * @var array
     */
    protected $dates = [
        'muted_at', 'muted_until', 'pinned_at',
    ];
}
