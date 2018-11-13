<template>
    <div class="content">
        <h3>Retensi Arsip SP2D Tahun Ini</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group list-group-flush">
                    <a href="javascript:void(0)" v-for="ret in retensi" :key="ret.id_arsip"
                        class="list-group-item list-group-item-danger">
                        {{ ret.surat.nomor_surat }} | Perkiraan Retensi : {{ ret.tgl_perkiraan_retensi | tanggalLokal }}
                    </a>
                    <a href="javascript:void(0)"
                        class="list-group-item list-group-item-light">
                        Batas list ditampilkan hanya sebanyak 50 arsip (total {{ total }} Arsip)
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger">
                <h5><i class="icon fa fa-ban"></i> Perhatian!</h5>

                <p>Menghapus data arsip melalui menu ini akan menghilangkan seluruh data yang ada dan tidak dapat dikembalikan! <br>
                    Mohon periksa kembali sebelum menggunakan fungsi ini!
                </p>

                <button class="btn btn-outline-light btn-block" @click="bulkRetensi" :disabled="retensi = {} ? true : false">
                        <i class="fas fa-trash mr-2"></i> Retensi Semua ({{ total }} Arsip)
                </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                retensi: {},
                total: ''
            }
        },

        created() {
            this.loadRetensi()
        },

        methods: {
            bulkRetensi() {
                axios.post('api/bulk-retensi')
                .then((response) => {
                    swal({
                        title: 'Retensi Selesai!',
                        text: response.data.messages,
                        type: 'success'
                    })
                    this.loadRetensi()
                })
            },

            loadRetensi() {
                if (this.isMasterOrAdmin()) {
                    axios.get('api/retensi')
                    .then((response) => {
                        if (response.data.data.length==0) {
                            swal({
                                title: 'Data tidak ditemukan',
                                text: "Retensi sudah dilakukan pada tahun ini",
                                type: 'info',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Kembali'
                                }).then((result) => {
                                if (result.value) {
                                    this.$router.push({ name: 'ArsipIndex' })
                                }
                            })
                        }
                        this.retensi = response.data.data
                        this.total = response.data.total
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                }
            }
        }
    }
</script>
