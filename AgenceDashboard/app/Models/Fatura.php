<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'cao_fatura';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'co_cliente','co_cliente');
    }
}
