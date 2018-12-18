<?php

namespace App;

use App\Pivot\UserFriends;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider', 'provider_id', 'name', 'email', 'image', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'user_friends', 'user_id', 'friend_id')
            ->withPivot(['muted_at', 'muted_until', 'pinned_at'])->using(UserFriends::class)
            ->withTimestamps();
    }

    /**
     * @return User
     */
    public function apiLogin()
    {
        $this->update(['api_token' => str_random(60)]);

        return $this;
    }
}
