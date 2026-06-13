<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'karyawan';

    protected $primaryKey = 'nik';

    public $incrementing = false;

    protected $keyType = 'string';

  protected $fillable = [
    'nik',
    'nama_lengkap',
    'jabatan',
    'no_hp',
    'password',
    'role',
    'foto',
];

    protected $hidden = [
        'password',
    ];
}