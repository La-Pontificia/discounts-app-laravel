<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class History extends Model
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'clientId',
    'userId',
    'discountId',
  ];

  public function client()
  {
    return $this->hasOne(Client::class, 'id', 'clientId');
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'userId');
  }

  public function discount()
  {
    return $this->hasOne(Discount::class, 'id', 'discountId');
  }
}
