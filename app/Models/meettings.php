<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meettings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'musos_id',
        'title_meetting',
        'date_meetting',
    ];
}