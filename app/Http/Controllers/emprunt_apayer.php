<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emprunt_apayer extends Model
{
    use HasFactory;

     protected $fillable = [
        'emprunts_id',
        'musos_id',
        'pmensuel',
        'intere_mensuel',
        'ttalmensuel',
        'paiement',
        'date_paiement',
    ];
    
}