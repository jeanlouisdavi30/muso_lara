<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class don extends Model
{
    use HasFactory;
    protected $table ="don";
    protected $fillable = [
        'musos_id',
        'partenaire_id',
        'titre',
        'montant',
        'date_decaissement',
        'numero_cb',
        'description', 
    ];
}