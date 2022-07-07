<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depenseCV extends Model
{
    use HasFactory;
    protected $table = "depensecv";

    protected $fillable = [
        'musos_id',
        'description',
        'date',
        'montant',
        'type',
        'beneficiare',
        'autre_detail',
    ];
}