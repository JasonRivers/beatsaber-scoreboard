<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Leaderboard
 *
 * @property int $id
 * @property int $competition_id
 * @property string $name
 * @property int $active
 * @property string $score_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Competition $competition
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Score[] $scores
 * @property-read int|null $scores_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereScoreType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Leaderboard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Leaderboard extends Model
{
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class)->orderBy('score', 'DESC');
    }

    public function topScores($limit)
    {
        switch ($this->score_type) {
            case ScoreType::TIME:
                $order = 'MIN(score) ASC';
                break;
            default:
                $order = 'MAX(score) DESC';
                break;
        }

        $scores = $this->scores()
            ->select([
                DB::raw('MAX(score) AS score'),
                'player_id'
            ])
            ->limit($limit)
            ->orderByRaw($order)
            ->with('player')
            ->groupBy('player_id')
            ->get();

        $table = $scores->map(function (Score $score) {
            return (object) [
                'score' => $score->score,
                'name' => $score->player->name
            ];
        });
        return $table->toArray();
    }
}