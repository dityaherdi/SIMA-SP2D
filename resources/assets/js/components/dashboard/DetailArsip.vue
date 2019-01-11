<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        Daftar Arsip SP2D hari ini
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="ars in arsip.data" :key="ars.id_arsip">
                                {{ ars.surat.nomor_surat }}
                                <button class="btn btn-primary btn-sm float-right ml-2" @click="showDetailModal(ars)">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <pagination :data="arsip" @pagination-change-page="getResults" :limit="1"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <detail-arsip></detail-arsip>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                arsip: {}
            }
        },
        components: {
            "detail-arsip" : require('./../master/arsip/children/DetailArsipModal.vue')
        },
        created() {
            axios.get('api/detail-arsip')
            .then((response) => {
                this.arsip = response.data.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/detail-arsip?page='+page)
                .then((response) => {
                    this.arsip = response.data.data
                })
            },
            showDetailModal(ars) {
                Signal.$emit('show_detail_arsip_modal', ars)
            }
        }
    }
</script>
