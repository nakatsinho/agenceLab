<template>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Resultado do Botão "Gráfico"</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item active">Gráfico</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <h4 class="card-title">Botão Gráfico<br /><small class="text-muted"> Apresentar em formato
                                    gráfico o desempenho de cada consultor, lado a lado. Apresentar, também, a
                                    linha que define o custo médio de todos, para se visualizar se os desempenhos estão
                                    acima desse custo para a
                                    empresa ou não.</small>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import http from '@/services/http';
import Chart from 'chart.js/auto'

export default {
    data() {
        return {
            startDate: this.$route.query.startDate,
            endDate: this.$route.query.endDate,
            selectedIds: this.$route.query.selectedIds ? this.$route.query.selectedIds.split(',') : [],
        };
    },
    
    mounted() {
        console.log("CHART");
        this.fetchChartData();
    },

    methods: {
        fetchChartData() {
            const apiUrl = 'chart-details-consultant';

            const requestData = {
                startDate: this.startDate,
                endDate: this.endDate,
                selectedIds: this.selectedIds.join(','),
            };

            http.get(apiUrl, { params: requestData })
                .then((response) => {
                    this.updateChart(response.data);
                    console.log(response.data);
                })
                .catch(error => console.error('Error fetching data:', error));
        },
        updateChart(data) {
            const monthLabels = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            // Extract unique co_usuario values
            const uniqueUsers = Array.from(new Set(data.map(item => item.no_usuario)));

            const datasets = [];

            uniqueUsers.forEach(no_usuario => {
                const userFilteredData = data.filter(item => item.no_usuario === no_usuario);
                const userValues = [];

                for (let i = 0; i < 12; i++) {
                    const filteredData = userFilteredData.filter(item => {
                        const date = new Date(item.data_emissao);
                        return date.getMonth() === i;
                    });

                    const totalValue = filteredData.reduce((acc, item) => acc + item.receita_liquida, 0);
                    userValues.push(totalValue);
                }

                const backgroundColors = this.generateRandomColors(1)[0];

                datasets.push({
                    label: no_usuario,
                    data: userValues,
                    backgroundColor: backgroundColors,
                    borderWidth: 1,
                });
            });

            // Cálculo da média da `receita_liquida` para todos consultores ao longo do mês
            const averageValues = Array.from({ length: 12 }, (_, i) => {
                const totalValue = datasets.reduce((acc, dataset) => acc + dataset.data[i], 0);
                return totalValue / datasets.length;
            });

            const averageColor = 'rgba(75, 192, 192, 1)';

            datasets.push({
                label: 'Média',
                data: averageValues,
                borderColor: averageColor,
                type: 'line',
                borderWidth: 2,
                fill: false
            });

            const chartData = {
                labels: monthLabels,
                datasets: datasets
            };

            const chartOptions = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        }
        ,
        generateRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        generateRandomColors(count) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(this.generateRandomColor());
            }
            return colors;
        }

    }
};

</script>

<style lang="scss" scoped></style>