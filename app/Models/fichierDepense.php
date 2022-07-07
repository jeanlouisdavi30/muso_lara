<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichierDepense extends Model
{
    use HasFactory;
protected $table = "fichier_depenses";
    protected $fillable = [
        'depensecr_id',
        'fichier',
        'type',
    ];
}