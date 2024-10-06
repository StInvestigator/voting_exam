<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $voting_id
 * @property int $candidate_id
 */

class Vote extends Model
{
    protected $table = "votes";

    protected $fillable = ['voting_id','user_id','candidate_id'];

    use HasFactory;
}
