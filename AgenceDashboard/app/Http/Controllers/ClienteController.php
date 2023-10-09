<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::where('TP_CLIENTE', 'A')
            ->get();
        return response()->json($clientes);
    }

    //TODO - ALL ABOUT BOTAO RELATORIO WORKFLOW
    private function calcularTotalReceitaCliente($client, $month)
    {
        $totalRevenue = Fatura::where('CO_CLIENTE', $client)
            ->where(DB::raw('MONTH(data_emissao)'), $month)
            ->sum(DB::raw('(VALOR - TOTAL_IMP_INC)'));

        return $totalRevenue;
    }

    private function calcularReceitaCliente($client, $startMonth, $endMonth)
    {
        $revenueData = [];

        foreach (range($startMonth, $endMonth) as $month) {
            $totalRevenue = $this->calcularTotalReceitaCliente($client, $month);
            $revenueData[$month] = $totalRevenue;
        }

        return $revenueData;
    }
    public function gerarTabelaCliente(Request $request)
    {
        // $selectedClients = [2, 3, 14];
        $startMonth = $request->input('startDate');
        $endMonth = $request->input('endDate');
        $selectedIds = $request->input('selectedIds');

        $selectedClients = explode(',', $selectedIds);

        $report = [];

        foreach ($selectedClients as $client) {
            $clientName = Fatura::where('co_cliente', $client)->first();
            $revenueData = $this->calcularReceitaCliente($client, $startMonth, $endMonth);
            $report[$client] = [
                "clientName" => optional(optional($clientName)->cliente)->no_razao ?? '',
                "revenues" => $revenueData
            ];
        }

        // return response()->json($report);
        return $report;
    }
    //!SECTION:: END OF BOTAO RELATORIO

    //TODO - ALL ABOUT BOTAO GRAFICO & PIZZA WORKFLOW
    public function gerarGraficoCliente(Request $request)
    {
        $clientId = 0;
        $startMonth = $request->input('startDate');
        $endMonth = $request->input('endDate');
        $selectedIds = $request->input('selectedIds');

        $selectedClients = explode(',', $selectedIds);

        $revenueData = Fatura::select('*', DB::raw('SUM(VALOR - TOTAL_IMP_INC) as net_revenue'), DB::raw('MONTH(data_emissao) as month'))
            ->whereIn('CO_CLIENTE', $selectedClients)
            ->whereBetween(DB::raw('CONCAT(YEAR(data_emissao), "-", MONTH(data_emissao))'), [$startMonth, $endMonth])
            ->groupBy('CO_CLIENTE', DB::raw('MONTH(data_emissao)'), 'co_fatura', 'co_sistema', 'co_os', 'num_nf', 'total', 'valor', 'data_emissao', 'corpo_nf', 'comissao_cn', 'total_imp_inc')
            ->get();

        $clients = [];
        foreach ($revenueData as $revenue) {
            $clientId = $revenue->co_cliente;
            $clientName = $revenue->cliente->no_razao;
            $month = $revenue->month;
            $netRevenue = $revenue->net_revenue;

            if (!isset($clients[$clientId])) {
                $clients[$clientId] = [
                    'clientName' =>  $clientName,
                    'revenues' => array_fill(1, 12, 0)
                ];
            }

            $clients[$clientId]['revenues'][$month] = $netRevenue;
        }

        return $clients;
    }
    //!SECTION - END OF BOTAO GRAFICO & PIZZA

}
