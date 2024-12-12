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
    'updaterId',
  ];

  protected $perPage = 20;

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'userId');
  }

  public function updater()
  {
    return $this->hasOne(User::class, 'id', 'updaterId');
  }

  public function histories()
  {
    return $this->HasMany(History::class, 'id', 'clientId');
  }

  public function displayName()
  {
    return $this->lastNames . ', ' . $this->firstNames;
  }

  public function displayType()
  {
    $clientTypes = [
      'alumno' => 'Alumno',
      'docente' => 'Docente',
      'directivo' => 'Directivo',
      'ppff' => 'Padre de familia',

    ];
    return $clientTypes[$this->type];
  }
}
