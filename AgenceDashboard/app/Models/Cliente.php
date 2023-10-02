<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'CAO_CLIENTE';

    public function faturas()
    {
        return $this->hasMany(Fatura::class, 'co_cliente','co_cliente');
    }
}
