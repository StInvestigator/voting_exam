<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property string $name
 * @property DateTime $start_at
 * @property DateTime $end_at
 * @property Collection|Candidate[] $candidates
 * @property int $totalVotesCount
 * @property string $currentStatus
 */
class Voting extends Model
{
    protected $table = "votings";

    protected $fillable = ['name','start_at','end_at'];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'voting_id', 'id');
    }

    public function getTotalVotesCountAttribute(): int
    {
        return $this->hasMany(Vote::class, 'voting_id', 'id')->get()->count();
    }

    public function getCurrentStatusAttribute(): string
    {
        return $this->end_at < now("Europe/Kiev") ? "Ended" : ($this->start_at < now("Europe/Kiev") ? "Ongoing" : "Sheduled");
    }

    use HasFactory;
}
