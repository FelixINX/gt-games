<?php

namespace App\Model\Scatt;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scatt_rounds';

    protected $fillable = ['game_id', 'done', 'letter'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'done' => 'boolean',
        'user_approval' => 'array',
    ];
}
