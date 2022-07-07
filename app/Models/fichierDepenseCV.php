<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichierDepenseCV extends Model
{
    use HasFactory;

    protected $table = "fichier_depense_cv";
    protected $fillable = [
        'depensecv_id',
        'fichier',
        'type',
    ];

}