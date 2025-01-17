<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public function commandes()
    {
        return $this->hasone(Commandes::class);
    }
    public function orders()
    {
        return $this->hasMany(orders::class);
    }
}