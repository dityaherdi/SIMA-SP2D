<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        List SP2D terbaru
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li v-if="surat.length==0" class="list-group-item">Tidak ada data</li>
                            <li class="list-group-item" v-for="sur in surat.data" :key="sur.id_surat">
                                {{ sur.nomor_surat }}
                                <button class="btn btn-primary btn-sm float-right ml-2" @click="showDetailModal(sur)">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <pagination :data="surat" @pagination-change-page="getResults" :limit="1"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <detail-surat></detail-surat>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                surat: {}
            }
        },
        components : {
            "detail-surat" : require('./../master/surat/children/DetailSuratModal.vue')
        },
        created() {
            axios.get('api/detail-surat')
            .then((response) => {
                this.surat = response.data.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/detail-surat?page='+page)
                .then((response) => {
                    this.surat = response.data.data
                })
                
            },
            showDetailModal(sur) {
                Signal.$emit('show_detail_surat_modal', sur)
            }
        }
    }
</script>
