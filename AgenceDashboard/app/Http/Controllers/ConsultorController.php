<?php

namespace App\Http\Controllers;

use App\Models\Consultor;
use App\Models\Permissao;
use App\Models\Salario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultorController extends Controller
{
    public function index()
    {
        // $permissao = Permissao::with('user')
        //     ->where('co_sistema', 1)
        //     ->where('in_ativo', 'S')
        //     ->whereIn('co_tipo_usuario', [0, 1, 2])
        //     ->get();

        // return $permissao;
        $consultores = User::join('PERMISSAO_SISTEMA', 'CAO_USUARIO.CO_USUARIO', '=', 'PERMISSAO_SISTEMA.CO_USUARIO')
            ->where('PERMISSAO_SISTEMA.CO_SISTEMA', 1)
            ->where('PERMISSAO_SISTEMA.IN_ATIVO', 'S')
            ->whereIn('PERMISSAO_SISTEMA.CO_TIPO_USUARIO', [0, 1, 2])
            ->with('permissao')
            ->get();


        return response()->json($consultores);
    }

    public function obterReceitaLiquida($startMonth, $endMonth, $consultor)
    {
        $resultados = DB::table('CAO_FATURA as FAT')
            ->join('CAO_OS as OS', 'FAT.co_os', '=', 'OS.co_os')
            ->join('CAO_USUARIO as CU', 'OS.co_usuario', '=', 'CU.co_usuario')
            ->where('CU.co_usuario', $consultor)
            ->whereBetween(DB::raw('CONCAT(YEAR(FAT.data_emissao), "-", MONTH(FAT.data_emissao))'), [$startMonth, $endMonth])
            ->select('CU.co_usuario', 'CU.no_usuario', 'FAT.data_emissao', DB::raw('SUM(FAT.valor - FAT.total_imp_inc) as receita_liquida'))
            ->groupBy('CU.co_usuario', 'CU.no_usuario', 'FAT.data_emissao')
            ->get();

        // return response()->json($data);
        return $resultados;
    }

    public function obterCustoFixo($consultor)
    {
        $custoFixoPorConsultor = Salario::where('co_usuario', $consultor)
            ->select('BRUT_SALARIO as total')->first();
        // return response()->json($custoFixoPorConsultor);
        return $custoFixoPorConsultor;
    }

    public function calcularComissao($startMonth, $endMonth, $consultor)
    {
        $resultados = DB::table('CAO_FATURA as FAT')
            ->join('CAO_OS as OS', 'FAT.co_os', '=', 'OS.co_os')
            ->join('CAO_USUARIO as CU', 'OS.co_usuario', '=', 'CU.co_usuario')
            ->where('CU.co_usuario', $consultor)
            ->whereBetween(DB::raw('CONCAT(YEAR(FAT.data_emissao), "-", MONTH(FAT.data_emissao))'), [$startMonth, $endMonth])
            ->select(DB::raw('SUM((FAT.valor - FAT.valor * FAT.total_imp_inc / 100) * FAT.comissao_cn / 100) as total'))
            ->first();

        // return response()->json($resultados);
        return $resultados;
    }

    public function calcularRelatorio(Request $request)
    {
        $startMonth = $request->input('startDate');
        $endMonth = $request->input('endDate');
        $selectedIds = $request->input('selectedIds');

        $consultoresSelecionados = explode(',', $selectedIds);

        $relatorioPorConsultor = [];
        $monthlySum = [];
        $relatorioLimpo = [];
        $iterator = 0;

        foreach ($consultoresSelecionados as $consultor) {
            $receitaLiquida = $this->obterReceitaLiquida($startMonth, $endMonth, $consultor);
            $custoFixo = $this->obterCustoFixo($consultor);
            $comissao = $this->calcularComissao($startMonth, $endMonth, $consultor);

            $relatorioPorConsultor[$iterator] = [
                "relatorio" => $receitaLiquida,
            ];
            $iterator++;
        }

        for ($k = 0; $k < count($consultoresSelecionados); $k++) {
            foreach ($relatorioPorConsultor[$k]['relatorio'] as $value) {
                $carbonDate = Carbon::parse($value->data_emissao);
                $month = $carbonDate->month;

                if (!isset($monthlySum[$month])) {
                    $monthlySum[$month] = 0;
                }

                $monthlySum[$month] += $value->receita_liquida;
                $lucro = $monthlySum[$month] - (($custoFixo ? $custoFixo->total : 0) + ($comissao ? $comissao->total : 0));

                $relatorioLimpo[$month] = [
                    "co_usuario" => $value->co_usuario,
                    "no_usuario" => $value->no_usuario,
                    "data_emissao" => $value->data_emissao,
                    "receita_liquida" => $monthlySum[$month],
                    "lucro" => $lucro,
                    "custo_fixo" => $custoFixo,
                    "comissao" => $comissao,
                ];
            }
            $relatorioPorConsultor[$k] = $relatorioLimpo;
        }

        return response()->json($relatorioPorConsultor);
    }



    public function obterGraficoReceitaLiquida(Request $request)
    {
        $startMonth = $request->input('startDate');
        $endMonth = $request->input('endDate');
        $selectedIds = $request->input('selectedIds');

        $consultoresSelecionados = explode(',', $selectedIds);
        $receitaLiquida = [];

        foreach ($consultoresSelecionados as $consultor) {
            $consultorData = $this->obterReceitaLiquida($startMonth, $endMonth, $consultor);
            $consultorDataArray = $consultorData->toArray();
            $receitaLiquida = array_merge($receitaLiquida, $consultorDataArray);
        }

        return $receitaLiquida;
    }

}
