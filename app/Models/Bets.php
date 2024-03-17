<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Bets extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bets';
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
        'user_id',
        'game_id',
        'bet_type',
        'bet_amount',
        'bet_potential_winnings',
        'status',
        'created_by'
    ];
}
