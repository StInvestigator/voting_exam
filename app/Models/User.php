<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property Collection|Vote[] $votes
 * @property Collection|Voting[] $attendedVotings
 * 
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class,"user_id","id");
    }

    public function getAttendedVotingsAttribute()
    {
        $votings = new Collection();
        foreach (Voting::all() as $voting) {
            if($this->votes()->where('voting_id','=',$voting->id)->exists()){
                $votings->push($voting);
            }
        }
        return $votings;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
