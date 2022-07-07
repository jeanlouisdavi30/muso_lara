<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichier_rbs extends Model
{
    use HasFactory;
      protected $fillable = [
        'paiement_emprunts_id',
        'fichier',
        'type',
    ];
}