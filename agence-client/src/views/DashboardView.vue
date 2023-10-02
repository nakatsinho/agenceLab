
<script>
import http from '@/services/http';

export default {
    data() {
        return {
            dashboard: {}
        };
    },
    methods: {
        getData() {
            http.get('dashboard')
                .then((response) => {
                    this.dashboard = response.data;
                    console.log('Dashdata:', this.dashboard);
                })
                .catch((error) => {
                    console.error('Error fetching consultants:', error);
                });
        },
        getProgressBarWidth(value) {
            const width = `${Math.min(value, 100)}%`;
            return width;
        }
    },
    mounted() {
        this.getData();
    }
}
</script>

<style lang="scss" scoped></style>

<template>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Painel de Controle</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                    <li class="breadcrumb-item active">Painel de Controle</li>
                </ol>
            </div>
        </div>
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-info"></i></h2>
                            <h3 class="">{{ dashboard.usuarios }}</h3>
                            <h6 class="card-subtitle">Total Usuários</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar"
                                    :style="{ width: getProgressBarWidth(dashboard.usuarios), height:10}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="mdi mdi-alert-circle text-success"></i></h2>
                            <h3 class="">{{ dashboard.clientes }}</h3>
                            <h6 class="card-subtitle">Total Clientes</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 40%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="mdi mdi-wallet text-purple"></i></h2>
                            <h3 class="">{{ dashboard.consultores }}</h3>
                            <h6 class="card-subtitle">Total Consultores</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="mdi mdi-buffer text-warning"></i></h2>
                            <h3 class="">{{ dashboard.facturas }}</h3>
                            <h6 class="card-subtitle">Total Facturas</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 26%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-8 col-xlg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h4 class="card-title">Yearly Earning</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <ul class="list-inline">
                                            <li>
                                                <h6 class="text-muted text-success"><i
                                                        class="fa fa-circle font-10 m-r-10 "></i>Sales</h6>
                                            </li>
                                            <li>
                                                <h6 class="text-muted  text-info"><i
                                                        class="fa fa-circle font-10 m-r-10"></i>Earning ($)</h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="earning" style="height: 355px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xlg-3">
                <div class="card card-inverse card-info">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="m-r-20 align-self-center">
                                <h1 class="text-white"><i class="ti-light-bulb"></i></h1>
                            </div>
                            <div>
                                <h3 class="card-title">Sales Analytics</h3>
                                <h6 class="card-subtitle">March 2017</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 align-self-center">
                                <h2 class="font-light text-white"><sup><small><i class="ti-arrow-up"></i></small></sup>35487
                                </h2>
                            </div>
                            <div class="col-6 p-t-10 p-b-20 text-right">
                                <div class="spark-count" style="height:65px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-inverse card-success">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="m-r-20 align-self-center">
                                <h1 class="text-white"><i class="ti-pie-chart"></i></h1>
                            </div>
                            <div>
                                <h3 class="card-title">Bandwidth usage</h3>
                                <h6 class="card-subtitle">March 2017</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 align-self-center">
                                <h2 class="font-light text-white">50 GB</h2>
                            </div>
                            <div class="col-6 p-t-10 p-b-20 text-right align-self-center">
                                <div class="spark-count2" style="height:65px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</template>