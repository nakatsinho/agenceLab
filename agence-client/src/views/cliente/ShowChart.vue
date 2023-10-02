<template>
    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>
  
<script>
//import Chart from 'chart.js';

export default {
    mounted() {
        // Dados dos clientes e suas receitas líquidas (substitua com seus dados reais)
        const clientes = ['Cliente 1', 'Cliente 2', 'Cliente 3'];
        const receitasLiquidas = [25000, 30000, 28000]; // Receita líquida de cada cliente

        // Calcular o total da receita líquida
        const totalReceitaLiquida = receitasLiquidas.reduce((total, receita) => total + receita, 0);

        // Calcular o percentual de receita líquida para cada cliente
        const percentuais = receitasLiquidas.map(receita => ((receita / totalReceitaLiquida) * 100).toFixed(2));

        // Configuração do gráfico de pizza
        const config = {
            type: 'pie',
            data: {
                labels: clientes,
                datasets: [{
                    label: 'Percentual de Receita Líquida',
                    data: percentuais,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                }
            }
        };

        // Criar o gráfico
        const ctx = this.$refs.chartCanvas.getContext('2d');
        new Chart(ctx, config);
    }
};
</script>
  