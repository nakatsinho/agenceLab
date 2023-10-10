<template>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Listagem de Consultores</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item active">Consultores</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Visualizar Detalhes</h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="start-date" class="col-md-2 col-form-label">Mês Inicio</label>
                                        <div class="col-md-10">
                                            <VueDatePicker v-model="inputStartDate" month-picker />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="end-date" class="col-md-2 col-form-label">Mês Fim</label>
                                        <div class="col-md-10">
                                            <VueDatePicker v-model="inputEndDate" month-picker />
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
                                        <th>Nascimento</th>
                                        <th>Email</th>
                                        <th>Usuario</th>
                                        <th>Telefone</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>NID</th>
                                        <th>Nome Completo</th>
                                        <th>Nascimento</th>
                                        <th>Email</th>
                                        <th>Usuario</th>
                                        <th>Telefone</th>
                                    </tr>
                                </tfoot>
                                <tbody v-if="this.consultants.length > 0">
                                    <tr v-for="(value, index) in this.consultants" :key="index">
                                        <td>
                                            <input type="checkbox" :id="'select_' + value.co_usuario" v-model="selectedIds"
                                                :value="value.co_usuario" />
                                            <label :for="'select_' + value.co_usuario"></label>
                                        </td>
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ value.no_usuario }}</td>
                                        <td>{{ value.dt_nascimento }}</td>
                                        <td>{{ value.no_email }}</td>
                                        <td>{{ value.co_usuario }}</td>
                                        <td>{{ value.nu_telefone }}</td>
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
    name: 'consultantsList',
    data() {
        return {
            consultants: [],
            selectAll: false,
            selectedIds: [],
            inputStartDate: null,
            inputEndDate: null,
            startDate: null,
            endDate: null
        }
    },
    mounted() {
        this.getConsultant();
    },
    watch:
    {
        inputStartDate(newstartDate) {
            this.handleDateUpdate('start', newstartDate);
        },
        inputEndDate(newendDate) {
            this.handleDateUpdate('end', newendDate);
        }
    },
    methods: {
        getConsultant() {
            http.get('consultores')
                .then((response) => {
                    this.consultants = response.data;
                    // console.log('Consultants:', this.consultants);
                })
                .catch((error) => {
                    console.error('Error fetching consultants:', error);
                });
        },

        toggleSelectAll() {
            this.selectedIds = this.selectAll ? this.consultants.map((consultant, index) => {
                console.log(index);
                return consultant.co_usuario;
            }) : [];
            console.log(this.selectedIds)
        },

        handleDateUpdate(type, date) {

            const selectedDate = date;
            const month = selectedDate.month + 1;
            const year = selectedDate.year;

            if (isNaN(month) || isNaN(year)) {
                this.showSweetAlert('Erro de Inserção', 'Porfavor, Selecione uma data válida', 'error');
                return;
            }

            if (type === 'start') {
                this.startDate = `${year}-${month.toString().padStart(2, '0')}`;
            } else if (type === 'end') {
                this.endDate = `${year}-${month.toString().padStart(2, '0')}`;
            }

            console.log('Start Date:', this.startDate);
            console.log('End Date:', this.endDate);
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
                    name: 'ConsultantDetails',
                    params: { id: operation },
                    query: selectedData,
                });
            } else if (operation == 2) {
                this.$router.push({
                    name: 'ConsultantPieDetails',
                    params: { id: operation },
                    query: selectedData,
                });
            } else if (operation == 3) {
                this.$router.push({
                    name: 'ConsultantBarDetails',
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