<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_id', 'donor_name', 'food_name', 'quantity', 
        'location', 'expiration', 'status', 'maps'
    ];   

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function decrementQuantity()
    {
        $this->decrement('quantity');

        if ($this->quantity <= 0) {
            $this->update(['status' => 'completed']);
        }
    }
}