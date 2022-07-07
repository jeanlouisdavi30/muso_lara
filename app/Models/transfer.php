<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    use HasFactory;

        protected $fillable = [
        'musos_id',
        'date_entre',
        'titre',
        'montant',
        'caisse',
        'transfer_caisse',
        'detail', 
    ];
}