<template>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Resultado do Botão "Relatório"</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item active">Relatório</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <h4 class="card-title">Resultado do Botão "Relatório"<br /><small class="text-muted">Apresentar,
                                    separado por
                                    cliente, a receita total gerada para cada mês de referência.</small>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div v-for="(clientData, clientIndex) in responseData" :key="clientIndex">
                                <h3>{{ clientData.clientName }}</h3>

                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Mês</th>
                                            <th>Receita Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(revenue, monthIndex) in clientData.revenues" :key="monthIndex">
                                            <td>{{ monthLabels[revenue.month - 1] }}</td>
                                            <td>{{ formatCurrency(revenue.revenue) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <h2>TOTAL</h2>
                                            </td>
                                            <td><b>{{ formatCurrency(calculateTotal(clientData.revenues.map(item =>
                                                item.revenue))) }}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import http from '@/services/http';

const convertObjectToArray = (obj) => {
    return Object.values(obj);
};

export default {
    name: 'ClientDetails',
    data() {
        return {
            responseData: [],
            startDate: this.$route.query.startDate,
            endDate: this.$route.query.endDate,
            selectedIds: this.$route.query.selectedIds ? this.$route.query.selectedIds.split(',') : [],
        };
    },
    mounted() {
        this.getClient();
    },
    computed: {
        monthLabels() {
            return [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
        }
    },
    methods: {
        getClient() {
            const apiUrl = 'table-details-client';

            const requestData = {
                startDate: this.startDate,
                endDate: this.endDate,
                selectedIds: this.selectedIds.join(','),
            };

            http.get(apiUrl, { params: requestData })
                .then(response => {
                    this.responseData = Object.keys(response.data).map(clientKey => {
                        const clientData = response.data[clientKey];
                        const revenues = clientData.revenues;

                        return {
                            clientName: clientData.clientName,
                            revenues: Object.keys(revenues).map(month => ({
                                month: month,
                                revenue: revenues[month]
                            }))
                        };
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },

        convertObjectToArray,
        formatCurrency(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        },
        calculateTotal(revenues) {
            return revenues.reduce((total, revenue) => total + parseFloat(revenue), 0);
        }
    }
};
</script>



<style lang="scss" scoped></style>