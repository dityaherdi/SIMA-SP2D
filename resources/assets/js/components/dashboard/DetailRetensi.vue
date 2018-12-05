<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        Arsip SP2D yang diperkirakan Retensi tahun ini
                        <div class="card-tools">
                        <router-link :to="{ name: 'ArsipIndex' }" tag="button" class="btn btn-primary btn-sm"
                            v-if="this.$store.state.currentUser.tipe=='Admin'">
                            <i class="fas fa-file-archive mr-2"></i> Semua Arsip
                        </router-link>
                    </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="r in retensiArs.data" :key="r.id_arsip">{{ r.surat.nomor_surat }}</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <pagination :data="retensiArs" @pagination-change-page="getResults" :limit="1"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                retensiArs: {}
            }
        },
        created() {
            axios.get('api/detail-retensi')
            .then((response) => {
                this.retensiArs = response.data.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/detail-retensi?page='+page)
                .then((response) => {
                    this.retensiArs = response.data.data
                })
            }
        }
    }
</script>
