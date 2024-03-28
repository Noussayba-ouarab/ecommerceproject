<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public function categories()
    {
        return $this->belongsTo(categories::class);
    }
    public function produits()
    {
        return $this->belongsTo(commandes::class);
    }
    public function orders()
    {
        return $this->hasOne(orders::class);
    }
}
