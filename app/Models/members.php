<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class members extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'users_id',
        'musos_id',
        'last_name',
        'first_name',
        'sexe',
        'date_birth',
        'email',
        'picture', 
        'actif',
        'function',
        'type_of_id',
                'id_number',
        'phone',
        'matrimonial_state',
    ];
}