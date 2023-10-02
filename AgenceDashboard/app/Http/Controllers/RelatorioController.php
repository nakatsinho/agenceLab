<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{

    public function resumoDashboard()
    {
        $factura = Fatura::all();

        $consultor = User::join('PERMISSAO_SISTEMA', 'CAO_USUARIO.CO_USUARIO', '=', 'PERMISSAO_SISTEMA.CO_USUARIO')
            ->where('PERMISSAO_SISTEMA.CO_SISTEMA', 1)
            ->where('PERMISSAO_SISTEMA.IN_ATIVO', 'S')
            ->whereIn('PERMISSAO_SISTEMA.CO_TIPO_USUARIO', [0, 1, 2])
            ->get();

        $cliente = Cliente::where('TP_CLIENTE', 'A')
            ->get();

        $user = User::all();

        return [
            "clientes" => $cliente->count(),
            "consultores" => $consultor->count(),
            "usuarios" => $user->count(),
            "facturas" => $factura->count(),
        ];
    }
}
