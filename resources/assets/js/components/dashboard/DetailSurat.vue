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
                            <li class="list-group-item" v-for="sur in surat.data" :key="sur.id_surat">
                                {{ sur.nomor_surat }} |  Terbit : {{ sur.tgl_terbit | tanggalLokal }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <pagination :data="surat" @pagination-change-page="getResults"></pagination>
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
                surat: {}
            }
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
                
            }
        }
    }
</script>
