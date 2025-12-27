<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Link extends Model
{
    use HasFactory;

    // Campos permitidos
    protected $fillable = ['title', 'url', 'sort_order', 'user_id'];

    // Relación inversa: Un Link pertenece a un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
