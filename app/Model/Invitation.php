<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['name', 'email', 'invitation_token', 'email_sent', 'registered_at'];

    public function generateInvitationToken() {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
    }

    /**
     * Get invitation link
     *
     * @param string $value
     * @return string
     */
    public function getLinkAttribute($value) {
        return urldecode(route('register') . '?token=' . $this->invitation_token);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_sent' => 'boolean',
    ];
}
