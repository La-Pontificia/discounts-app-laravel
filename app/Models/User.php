<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;
  protected $fillable = [
    'firstNames',
    'lastNames',
    'role',
    'businessName',
    'email',
    'status',
    'password',
    'lastSession',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'lastSession' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function clients()
  {
    return $this->HasMany(User::class, 'id', 'userId');
  }

  public function discounts()
  {
    return $this->HasMany(Discount::class, 'id', 'userId');
  }

  public function histories()
  {
    return $this->HasMany(History::class, 'id', 'userId');
  }

  public function roleDisplayName()
  {
    $roles = [
      'admin' => 'Administrador',
      'business' => 'Negocio',
      'admin-global' => 'Administrador global',
    ];

    return $roles[$this->role];
  }

  public function statusDisplayName()
  {
    return $this->status ? [
      'label' => 'Activo',
      'className' => 'bg-green-100 text-green-800 border-green-400',
    ] : [
      'label' => 'Inactivo',
      'className' => 'bg-red-100 text-red-800 border-red-400',
    ];
  }

  public function displayName()
  {
    return $this->firstNames . ' ' . $this->lastNames;
  }
}
