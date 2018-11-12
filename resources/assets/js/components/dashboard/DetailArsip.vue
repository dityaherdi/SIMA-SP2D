<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        List Arsip SP2D terbaru
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="ars in arsip.data" :key="ars.id_arsip">
                                {{ ars.surat.nomor_surat }} - {{ ars.tgl_diarsipkan | tanggalLokal }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <pagination :data="arsip" @pagination-change-page="getResults"></pagination>
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
                arsip: {}
            }
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
            }
        }
    }
</script>
