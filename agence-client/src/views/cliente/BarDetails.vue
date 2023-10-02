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
            clientsData: null,
            startDate: this.$route.query.startDate,
            endDate: this.$route.query.endDate,
            selectedIds: this.$route.query.selectedIds ? this.$route.query.selectedIds.split(',') : [],
        };
    },
    mounted() {
        this.fetchChartData();
    },

    methods: {
        fetchChartData() {
            const apiUrl = 'chart-details-client';

            const requestData = {
                startDate: this.startDate,
                endDate: this.endDate,
                selectedIds: this.selectedIds.join(','),
            };

            http.get(apiUrl, { params: requestData })
                .then(response => {
                    this.clientsData = response.data;
                    console.log('Data:', this.clientsData);
                    this.updateChart();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        updateChart() {
            const monthLabels = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const datasets = [];
            const averageValues = Array.from({ length: 12 }, () => 0);

            for (const clientId in this.clientsData) {
                const client = this.clientsData[clientId];
                const userValues = [];

                for (let i = 0; i < 12; i++) {
                    userValues.push(client.revenues[i + 1] || 0);
                    averageValues[i] += client.revenues[i + 1] || 0;
                }

                const backgroundColors = this.generateRandomColors(1)[0];

                datasets.push({
                    label: client.clientName,
                    data: userValues,
                    backgroundColor: backgroundColors,
                    borderWidth: 1,
                });
            }

            for (let i = 0; i < 12; i++) {
                averageValues[i] /= Object.keys(this.clientsData).length;
            }

            datasets.push({
                label: 'Média',
                data: averageValues,
                borderColor: 'rgba(75, 192, 192, 1)',
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