<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partenaire extends Model
{
    use HasFactory;

    protected $table = "partenaires";
    protected $fillable = [
        'name',
        'musos_id',
        'adresse',
        'telf',
        'representant',
        'email',
        'site_web',
        'text_representant', 
        'logo',
    ];
    
}