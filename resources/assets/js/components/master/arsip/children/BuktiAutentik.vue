<template>
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Penggunaan Arsip Sebagai Bukti Autentik</h3>
        </div>
        <div class="card-body">
            <div id="accordion">
                <div class="card card-info" v-for="buk in bukti" :key="buk.id_arsip">
                    <div class="card-header">

                        <a data-toggle="collapse" data-parent="#accordion" :href="'#'+'ket'+buk.id_arsip" class="collapsed" aria-expanded="false">
                            {{ buk.surat.nomor_surat }}
                        </a>
                        <span class="float-right">Tanggal Penggunaan Sejak : {{ buk.updated_at | tanggalLokal }}</span>

                    </div>
                    <div :id="'ket'+buk.id_arsip" class="panel-collapse in collapse" style="">
                        <div class="card-body">
                            <p>Keterangan : {{ buk.keterangan }} </p>
                            <button class="btn btn-success btn-sm" @click="buktiDone(buk.id_arsip)">
                                <i class="fas fa-check-circle mr-2"></i> Penggunaan Selesai
                            </button>
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
                bukti: {}
            }
        },

        created() {
            this.loadBukti()
        },

        methods: {
            loadBukti() {
                if (this.isMasterOrAdmin()) {
                    axios.get('api/get-bukti-autentik')
                    .then((response) => {
                        this.bukti = response.data.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                }
            },

            buktiDone(id) {
                swal({
                    title: 'Kembalikan arsip ini?',
                    text: "Pastikan arsip ini sudah selesai digunakan!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Penggunaan Selesai',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        if (this.isMasterOrAdmin()) {
                            axios.post('api/bukti-done/'+id)
                            .then((response) => {
                                toast({
                                    type: 'success',
                                    title: response.data.message
                                })
                                this.loadBukti()
                                this.$Progress.finish()
                            })
                            .catch((error) => {
                                console.log(error)
                                this.$Progress.fail()
                            })
                        }
                    }
                })
            }
        }
    }
</script>

