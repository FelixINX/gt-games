<?php

namespace App\Model\Scatt;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scatt_categories';

    protected $fillable = ['title', 'rules'];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
