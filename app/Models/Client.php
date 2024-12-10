<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'firstNames',
    'lastNames',
    'businessUnit',
    'documentId',
    'type',
    'status',
    'userId',
  ];

  protected $perPage = 20;

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'userId');
  }

  public function histories()
  {
    return $this->HasMany(History::class, 'id', 'clientId');
  }

  public function displayName()
  {
    return $this->firstNames . ' ' . $this->lastNames;
  }
}
