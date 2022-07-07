<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'musos_id',
        'curency',
        'meeting_interval',
        'comity_president',
        'comity_treasurer',
        'cv_cotisation_amount',
        'cr_cotisation_amount',
        'language',
    ];
}