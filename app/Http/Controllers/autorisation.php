<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autorisation extends Model
{
    use HasFactory;
     protected $fillable = [
        'musos_id',
        'members_id',
        'password',
    ];

}