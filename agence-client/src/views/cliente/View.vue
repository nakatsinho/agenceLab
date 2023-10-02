<template>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Listagem de Clientes</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item active">Clientes</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Visualização de Dados</h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="start-date" class="col-md-2 col-form-label">Mês Inicio</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" v-model="startDate" id="start-date"
                                                @input="validateMonthInput('start')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="end-date" class="col-md-2 col-form-label">Mês Fim</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" v-model="endDate" id="end-date"
                                                @input="validateMonthInput('end')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <button @click="viewSelected(1)" class="btn btn-outline-success btn-rounded"><i
                                            class="fa fa-table"></i> Ver
                                        Tabelas</button>
                                </div>
                                <div class="col-md-3">
                                    <button @click="viewSelected(2)" class="btn btn-outline-warning btn-rounded"><i
                                            class="fa fa-pie-chart"></i> Ver
                                        Gráfico Pizza</button>
                                </div>
                                <div class="col-md-4">
                                    <button @click="viewSelected(3)" class="btn btn-outline-danger btn-rounded"><i
                                            class="fa fa-bar-chart"></i> Ver
                                        Gráfico Barras</button>
                                </div>
                            </div>
                            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select_all" v-model="selectAll"
                                                @change="toggleSelectAll" />
                                            <label for="select_all"><strong>All</strong></label>
                                        </th>
                                        <th>NID</th>
                                        <th>Nome Completo</th>
                                        <th>Codigo</th>
                                        <th>Endereço</th>
                                        <th>CPNJ</th>
                                        <th>Telefone</th>
                                        <!-- <th>Acções</th> -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><input type="checkbox" name="" id=""></th>
                                        <th>NID</th>
                                        <th>Nome Completo</th>
                                        <th>Codigo</th>
                                        <th>Endereço</th>
                                        <th>CPNJ</th>
                                        <th>Telefone</th>
                                        <!-- <th>Acções</th> -->
                                    </tr>
                                </tfoot>
                                <tbody v-if="this.clients.length > 0">
                                    <tr v-for="(value, index) in this.clients" :key="index">
                                        <td>
                                            <input type="checkbox" :id="'select_' + (index + 1)" v-model="selectedIds"
                                                :value="index + 1" />
                                            <label :for="'select_' + (index + 1)"></label>
                                        </td>

                                        <td>{{ index + 1 }}</td>
                                        <td>{{ value.no_razao }}</td>
                                        <td>{{ value.co_cliente }}</td>
                                        <td>{{ value.ds_endereco }}</td>
                                        <td>{{ value.nu_cnpj }}</td>
                                        <td>{{ value.nu_telefone }}</td>
                                        <!-- <td>
                                            <router-link :to="'/client/' + value.id" type="button"
                                                class="btn btn-outline-success btn-rounded">
                                                <i class="fa fa-table"></i>
                                            </router-link>

                                            <router-link :to="'/pie-chart-client/' + value.id" type="button"
                                                class="btn btn-outline-warning btn-rounded">
                                                <i class="fa fa-pie-chart"></i>
                                            </router-link>

                                            <router-link :to="'/bar-chart-client/' + value.id" type="button"
                                                class="btn btn-outline-danger btn-rounded">
                                                <i class="fa fa-bar-chart"></i>
                                            </router-link>
                                        </td> -->
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="7">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import http from '@/services/http';
import Swal from 'sweetalert2';

export default {
    name: 'clientsList',
    data() {
        return {
            clients: [],
            selectAll: false,
            selectedIds: [],
            startDate: '',
            endDate: ''
        }
    },
    mounted() {
        this.getClient();
    },
    methods: {

        getClient() {
            http.get('clientes')
                .then((response) => {
                    this.clients = response.data;
                })
                .catch((error) => {
                    console.error('Error fetching cliente:', error);
                });
        },

        toggleSelectAll() {
            this.selectedIds = this.selectAll ? this.clients.map((_, index) => index + 1) : [];
        },

        validateMonthInput(type) {
            let input = type === 'start' ? this.startDate : this.endDate;
            const parsedValue = parseInt(input);
            if (isNaN(parsedValue) || parsedValue < 1 || parsedValue > 12) {
                if (type === 'start') {
                    this.startDate = '';
                } else {
                    this.endDate = '';
                }
            }
        },

        viewSelected(param) {

            if (!this.startDate || !this.endDate || this.selectedIds.length === 0) {
                this.showSweetAlert('Erro de Validação', 'Porfavor, Selecione um cliente e/ou preencha as datas', 'error');
                return;
            }

            this.submitForm(param);
        },

        submitForm(operation) {

            const selectedData = {
                startDate: this.startDate,
                endDate: this.endDate,
                selectedIds: this.selectedIds.join(','),
            };

            if (operation == 1) {
                this.$router.push({
                    name: 'ClientDetails',
                    params: { id: operation },
                    query: selectedData,
                });
            } else if (operation == 2) {
                this.$router.push({
                    name: 'ClientPieDetails',
                    params: { id: operation },
                    query: selectedData,
                });
            } else if (operation == 3) {
                this.$router.push({
                    name: 'ClientBarDetails',
                    params: { id: operation },
                    query: selectedData,
                });
            } else {
                this.showSweetAlert('Erro de Validação', 'Porfavor, Verifique os parametros da tua seleção! Não reconhecemos essa entrada', 'error');
                return;
            }
        },

        showSweetAlert(header, message, type) {
            Swal.fire({
                text: message,
                icon: type,
                timer: 3000,
                timerProgressBar: true,
                title: header,
                confirmButtonText: 'OK',
            });
        }
    }
};

</script>

<style lang="scss" scoped></style>