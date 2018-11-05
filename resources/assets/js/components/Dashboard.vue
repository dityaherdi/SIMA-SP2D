<template>
    <div class="content">
        <div class="jumbotron">
            <h1 class="display-4">Halo, {{ currentUser.nama }}!</h1>
            <p class="lead">Ini adalah panel administrator Sistem Manajemen Arsip Surat Perintah Pencairan Dana (SIMA - SP2D).</p>
            <hr class="my-4">
            <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        </div>
        <div class="row mb-3">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>

                <p>SP2D masuk hari ini.</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <router-link :to="{ name: 'SuratIndex' }" class="small-box-footer">
                Lihat Semua SP2D <i class="fa fa-arrow-circle-right"></i>
            </router-link>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>SP2D diarsipkan hari ini.</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-archive"></i>
            </div>
            <router-link :to="{ name: 'ArsipIndex' }" href="#" class="small-box-footer">
                Lihat Semua Arsip <i class="fa fa-arrow-circle-right"></i>
            </router-link>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>

                <p>Total media penyimpanan</p>
            </div>
            <div class="icon">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <a href="#" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>

                <p>Arsip SP2D retensi tahun ini.</p>
            </div>
            <div class="icon">
                <i class="fas fa-eraser"></i>
            </div>
            <a href="#" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
            </div>
        </div>
        <!-- ./col -->
        </div>
        <h3>SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </li>
                </ul>
            </div>
        </div>

        <h3>Arsip SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-success badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-success badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-success badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-success badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-success badge-pill">NEW</span>
                    </li>
                </ul>
            </div>
        </div>

        <h3>Retensi Arsip SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-danger badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-danger badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-danger badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-danger badge-pill">NEW</span>
                    </li>
                    <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        Cras justo odio
                        <span class="badge badge-danger badge-pill">2018-10-10</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
    }
</script>

