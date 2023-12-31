<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $table = 'permissao_sistema';

    public function user()
    {
        return $this->belongsTo(User::class, 'CO_USUARIO', 'CO_USUARIO');
    }
}
