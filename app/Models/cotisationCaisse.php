<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cotisationCaisse extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'members_id',
        'meettings_id',
        'musos_id',
        'montant',
        'type_caisse',
        'date_paiement',
    ];
}