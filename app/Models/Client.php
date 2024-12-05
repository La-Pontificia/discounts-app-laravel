<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'names',
    'first_sursname',
    'second_sursname',
    'business_unit',
    'dni',
    'type',
    'status',
    'user_id',
  ];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }

  public function histories()
  {
    return $this->HasMany(History::class, 'id', 'client_id');
  }
}
