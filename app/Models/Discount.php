<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Discount extends Model
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'amount',
    'userId',
    'creatorId'
  ];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'userId');
  }

  public function creator()
  {
    return $this->hasOne(User::class, 'id', 'creatorId');
  }

  public function histories()
  {
    return $this->HasMany(History::class, 'id', 'discountId');
  }
}
