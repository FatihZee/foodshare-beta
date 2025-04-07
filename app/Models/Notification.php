<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'claim_id',
        'phone',
        'message',
        'is_sent',
        'is_read',
    ];
}