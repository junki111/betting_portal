<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'games';
    protected $guarded = [];

    public function created_by()
    {
        $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'home_team',
        'home_team_odds',
        'away_team',
        'away_team_odds',
        'draw',
        'draw_odds',
        'game_date',
        'status',
        'created_by',
        'game_type_id',
    ];
}
