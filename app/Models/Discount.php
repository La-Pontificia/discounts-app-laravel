<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'amount',
        'user_id',
        'created_user_id'
    ];

    public function user()
    {
      return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function createdUser()
    {
      return $this->hasOne(User::class, 'id', 'created_user_id');
    }

    public function histories()
    {
      return $this->HasMany(History::class, 'id', 'discount_id');
    }
}
