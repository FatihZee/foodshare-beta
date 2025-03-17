<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_id', 'food_name', 'quantity', 'location', 'expiration', 'status'
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
    
    public function decrementQuantity()
    {
        // Kurangi jumlah makanan
        $this->decrement('quantity');

        // Kalau quantity = 0, ubah status jadi completed
        if ($this->quantity <= 0) {
            $this->update(['status' => 'completed']);
        }
    }
}