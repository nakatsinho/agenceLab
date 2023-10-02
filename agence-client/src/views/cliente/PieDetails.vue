<template>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Resultado do Botão "Pizza"</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item active">Pizza</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <h4 class="card-title">Botão Pizza<br /><small class="text-muted">Apresentar o percentual de
                                    receita líquida gerada por cada consultor, relacionado ao total de receita
                                    líquida gerada por todos os consultores envolvidos na consulta.</small>
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
                    this.updateChart(this.clientsData);
                })
                .catch(error => console.error('Error fetching data:', error));
        },
        updateChart(data) {
            const clientNames = Object.values(data).map(client => client.clientName);
            const backgroundColors = this.generateRandomColors(clientNames.length);

            const chartData = {
                labels: clientNames,
                datasets: [{
                    data: Object.values(data).map(client => {
                        return Object.values(client.revenues).reduce((acc, revenue) => acc + revenue, 0);
                    }),
                    backgroundColor: backgroundColors,
                    borderWidth: 1,
                }],
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
            };

            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'pie',
                data: chartData,
                options: chartOptions,
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