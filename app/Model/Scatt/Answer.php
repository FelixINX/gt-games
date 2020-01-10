<?php

namespace App\Model\Scatt;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scatt_answers';

    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = ['round_id', 'category_id', 'user_id', 'content', 'user_approval', 'approved'];

    public function round()
    {
        return $this->belongsTo(Round::class, 'round_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean',
        'user_approval' => 'array'
    ];
}
