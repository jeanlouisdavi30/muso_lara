<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pretAprouver extends Model
{
    use HasFactory;
    protected $fillable = [
        'prets_id',
        'musos_id',
        'old_montant',
        'new_montant',
    ];
}