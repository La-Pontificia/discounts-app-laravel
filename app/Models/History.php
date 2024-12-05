<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id',
        'user_id',
        'discount_id',
    ];

    public function client()
    {
      return $this->hasOne(User::class, 'id', 'client_id');
    }

    public function user()
    {
      return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function discount()
    {
      return $this->hasOne(Discount::class, 'id', 'discount_id');
    }
}
