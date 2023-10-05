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
                            <h4 class="card-title">Botão Relatório<br /><small class="text-muted">Apresentar, separado por
                                    consultor, o resultado de receitas geradas por cada profissional.</small>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                                <div v-for="(userData, userIndex) in responseData" :key="userIndex">
                                    <h3 v-if="userData.length > 1">{{ userData.no_usuario }}</h3>

                                    <table class="display nowrap table table-hover table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Período</th>
                                                <th>Receita Líquida</th>
                                                <th>Custo Fixo</th>
                                                <th>Comissão</th>
                                                <th>Lucro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data, dataIndex) in userData" :key="dataIndex">
                                                <td style="width:50px;">
                                                    <span class="round">
                                                        <img src="#" alt="user" width="50">
                                                    </span>
                                                </td>
                                                <td>
                                                    <h6>{{ data.data_emissao }}</h6>
                                                    <small class="text-muted">
                                                        {{ data.no_usuario }} | {{ data.co_usuario }}
                                                    </small>
                                                </td>
                                                <td>{{ formatCurrency(data.receita_liquida) }}</td>
                                                <td>{{ formatCurrency(data.custo_fixo.total) }}</td>
                                                <td>{{ formatCurrency(data.comissao.total) }}</td>
                                                <td>{{ formatCurrency(data.lucro) }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <h3>TOTAL</h3>
                                                </td>
                                                <td></td>
                                                <td>{{ formatCurrency(calculateTotal().receita_liquida) }}</td>
                                                <td>{{ formatCurrency(calculateTotal()['custo_fixo.total']) }}</td>
                                                <td>{{ formatCurrency(calculateTotal()['comissao.total']) }}</td>
                                                <td>{{ formatCurrency(calculateTotal().lucro) }}</td>
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
    </div>
</template>

<script>
import http from '@/services/http';

export default {
    name: 'ConsultantDetails',
    data() {
        return {
            responseData: [],
            startDate: this.$route.query.startDate,
            endDate: this.$route.query.endDate,
            selectedIds: this.$route.query.selectedIds ? this.$route.query.selectedIds.split(',') : [],
        };
    },
    methods: {
        formatCurrency(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        },
        calculateTotal() {
            return this.responseData.reduce((totals, item) => {
                Object.values(item).forEach(user => {
                    totals.receita_liquida += parseFloat(user.receita_liquida) || 0;
                    totals['custo_fixo.total'] += parseFloat(user.custo_fixo.total) || 0;
                    totals['comissao.total'] += parseFloat(user.comissao.total) || 0;
                    totals.lucro += parseFloat(user.lucro) || 0;
                });
                return totals;
            }, {
                receita_liquida: 0,
                'custo_fixo.total': 0,
                'comissao.total': 0,
                lucro: 0
            });
        }

    },
    mounted() {
        const apiUrl = 'table-details-consultant';

        const requestData = {
            startDate: this.startDate,
            endDate: this.endDate,
            selectedIds: this.selectedIds.join(','),
        };

        http.get(apiUrl, { params: requestData })
            .then((response) => {
                this.responseData = response.data;
                console.log(response.data);
            })
            .catch((error) => {
                console.error('Error fetching consultants:', error);
            });
    }
};
</script>



<style lang="scss" scoped></style>