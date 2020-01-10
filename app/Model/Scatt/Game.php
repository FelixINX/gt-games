<?php

namespace App\Model\Scatt;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scatt_games';

    protected $fillable = ['timer', 'number_of_rounds', 'user_id', 'active', 'started', 'state', 'active_round_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'scatt_category_scatt_game');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'scatt_game_user');
    }

    public function rounds()
    {
        return $this->hasMany(Round::class, 'game_id');
    }

    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Round::class);
    }

    public function hasUser($userId)
    {
        foreach ($this->users as $user) {
            if ($user->id == $userId) {
                return true;
            }
        }
    }

    public function activeRound()
    {
        return $this->belongsTo(Round::class, 'active_round_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'started' => 'boolean',
        'users_reputation' => 'array'
    ];
}
