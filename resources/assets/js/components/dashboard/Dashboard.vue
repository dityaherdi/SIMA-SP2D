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
                <h3>{{ surToday }}</h3>

                <p>SP2D masuk hari ini (Sistem)</p>
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
                <h3>{{ arsToday }}</h3>

                <p>SP2D diarsipkan hari ini (Sistem)</p>
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
                <h3>{{ totalStorage }}</h3>

                <p>Total media penyimpanan aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <router-link :to="{ name: 'DetailPenyimpanan' }" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </router-link>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ retThisYear }}</h3>

                <p>Arsip akan diretensi tahun ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-eraser"></i>
            </div>
            <router-link :to="{ name: 'DetailRetensi' }" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </router-link>
            </div>
        </div>
        <!-- ./col -->
        </div>
        <h3>SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="list-group list-group-flush">
                    <a href="javascript:void(0)" v-for="s in latestSur" :key="s.id_sp2d"
                        class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center">
                        {{ s.nomor_surat }} &nbsp;|&nbsp; Terbit : {{ s.tgl_terbit | tanggalLokal }}
                        <span class="badge badge-primary badge-pill">NEW</span>
                    </a>
                </div>
            </div>
        </div>

        <h3>Arsip SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="list-group list-group-flush">
                    <a href="javascript:void(0)" v-for="a in latestArs" :key="a.id_arsip"
                        class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                        {{ a.surat.nomor_surat }} &nbsp;|&nbsp; Diarsipkan : {{ a.tgl_diarsipkan | tanggalLokal }}
                        <span class="badge badge-success badge-pill">NEW</span>
                    </a>
                </div>
            </div>
        </div>

        <h3>Retensi Arsip SP2D Terbaru</h3>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="list-group list-group-flush">
                    <a href="javascript:void(0)" v-for="r in latestRet" :key="r.id_retensi"
                        class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                        {{ r.nomor_surat }} &nbsp;|&nbsp; Dihapus di sistem : {{ r.created_at | tanggalLokal }}
                        <span class="badge badge-danger badge-pill">NEW</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                surToday: '',
                arsToday: '',
                storage: {},
                totalStorage: '',
                retThisYear: '',
                latestSur: {},
                latestArs: {},
                latestRet: {},
            }
        },

        created() {
            this.suratToday()
            this.arsipToday()
            this.countStorage()
            this.retensiThisYear()
            this.latestSurat()
            this.latestArsip()
            this.latestRetensi()
        },

        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        },

        methods: {
            suratToday() {
                axios.get('api/surat-today')
                .then((response) => {
                    this.surToday = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            arsipToday() {
                axios.get('api/arsip-today')
                .then((response) => {
                    this.arsToday = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            countStorage() {
                axios.get('api/total-storage')
                .then((response) => {
                    this.storage = response.data.data
                    this.totalStorage = response.data.data.countedGed + 
                                        response.data.data.countedRua + 
                                        response.data.data.countedRak + 
                                        response.data.data.countedBox
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            retensiThisYear() {
                axios.get('api/retensi-this-year')
                .then((response) => {
                    this.retThisYear = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            latestSurat() {
                axios.get('api/latest-surat')
                .then((response) => {
                    this.latestSur = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            latestArsip() {
                axios.get('api/latest-arsip')
                .then((response) => {
                    this.latestArs = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            latestRetensi() {
                axios.get('api/latest-retensi')
                .then((response) => {
                    this.latestRet = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            }
        }
    }
</script>

