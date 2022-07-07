<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class decision extends Model
{
    use HasFactory;
    protected $table = "decisions";
        protected $fillable = [
        'musos_id',
        'title_decision',
        'decision',
        'meettings_id',
    ];
}