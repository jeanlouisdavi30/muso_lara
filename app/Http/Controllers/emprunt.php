<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emprunt extends Model
{
    use HasFactory;
     protected $fillable = [
        'musos_id',
        'partenaire_id',
        'titre',
        'montant',
        'pourcentage_interet',
        'date_decaissement',
        'duree',
        'pmensuel',
        'intere_mensuel',
        'ttalmensuel',
        'montanttotal',
        'frais',
        'echeance',
        'description',
     ];

}