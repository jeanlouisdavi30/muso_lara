<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement_emprunt extends Model
{
    use HasFactory;
    
    protected $table = "paiement_emprunts";
    protected $fillable = [
        'id_emprunt_apayers',
        'musos_id',
        'date_du_paiement',
        'date_pay',
        'numeropc',
        'montant',
        'interet_payer',
        'principale_payer',
        'balance_versement',
        'balance_tt_pret',
        'description',
        'statut',
    ];
}