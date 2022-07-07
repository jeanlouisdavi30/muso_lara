<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichier_pret extends Model
{
    use HasFactory;
    protected $table = "fichier_prets";
     protected $fillable = [
        'emprunts_id',
        'fichier',
        'type',
    ];

}