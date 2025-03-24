<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'profilePicture'
    ];    

    protected $hidden = [
        'password',
    ];
    
    public function wishlist()
    {
        return $this->belongsToMany(Donation::class, 'wishlists');
    }

}