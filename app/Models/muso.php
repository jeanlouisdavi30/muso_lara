<?php

namespace App\Models;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class muso extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "musos";
    protected $fillable = [
        'name_muso',
        'representing',
        'registered_date',
        'network',
        'contry',
        'phone',
        'Montant_cotisation', 
        'users_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);    
    }

}