<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reglement extends Model
{
    use HasFactory;
    protected $fillable = [
        'reglement',
        'musos_id',
    ];
}