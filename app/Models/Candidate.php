<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $image_id
 * @property Image $image
 * @property int $votesCount
 * @property Voting $voting
 */

class Candidate extends Model
{
    protected $table = "candidates";

    protected $fillable = ['first_name','last_name'];

    use HasFactory;

    public function image(): BelongsTo{
        return $this->belongsTo(Image::class,'image_id','id');
    }
    public function getVotesCountAttribute(): int{
        return $this->hasMany(Vote::class,"candidate_id","id")->get()->count();
    }
    public function voting(): BelongsTo{
        return $this->belongsTo(Voting::class,'voting_id','id');
    }
}
