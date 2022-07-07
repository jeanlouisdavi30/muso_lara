<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address_musos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'address',
        'city',
        'arondisment',
        'departement',
        'pays',
        'musos_id',
    ];
}