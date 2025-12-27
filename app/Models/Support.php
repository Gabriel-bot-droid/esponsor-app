<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    // Campos permitidos
    protected $fillable = ['supporter_name', 'message', 'amount', 'user_id'];

    // Relación inversa: Un Apoyo pertenece a un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}