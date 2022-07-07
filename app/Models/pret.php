<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pret extends Model
{
    use HasFactory;

    protected $fillable = [
        'musos_id',
        'members_id',
        'caisse',
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
        'statut',
        'echeance',
        'description',
    ];
}