<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichier_don extends Model
{
    use HasFactory;
    protected $table = "fichier_dons";
    protected $fillable = [
        'depensecr_id',
        'fichier',
        'type',
    ];
}