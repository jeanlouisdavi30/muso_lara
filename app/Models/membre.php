<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membre extends Model
{
    use HasFactory;
    protected $table = "membres";
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'tranche_age',
        'email',
        'foto',
        'actif',
        'adresse',
        'muso_id',
        'users_id',
    ];
}