<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Gedung Arsip</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Gedung">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                  <tr>
                    <th>Kode Gedung</th>
                    <th>Nama Gedung</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-for="ged in gedung" :key="ged.id_gedung">
                    <td>{{ ged.kode_gedung | uppercase}}</td>
                    <td>{{ ged.nama_gedung }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Gedung"
                            @click="showDetailGedungModal(ged)">
                            <i class="fas fa-eye "></i>
                        </a>
                        |
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Gedung"
                            @click="showEditingModal(ged)">
                            <i class="fas fa-edit"></i>
                        </a>
                        |
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                            title="Hapus Data Gedung"
                            @click="deleteGedung(ged.id_gedung)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->
        <modal-gedung></modal-gedung>
        <detail-gedung></detail-gedung>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gedung: {}
            }
        },

        created() {
            this.loadGedung()
            Signal.$on('load_gedung', () => {
                this.loadGedung();
            })
        },

        components: {
          "modal-gedung": require('./children/GedungModal.vue'),
          "detail-gedung": require('./children/DetailGedungModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_gedung_modal')
            },

            showEditingModal(ged) {
                Signal.$emit('show_editing_gedung_modal', ged)
            },

            showDetailGedungModal(ged) {
                Signal.$emit('show_detail_gedung_modal', ged)
            },

            loadGedung() {
                axios.get('api/gedung')
                .then((response) => {
                    this.gedung = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },

            deleteGedung(id) {
                swal({
                    title: 'Hapus Data Gedung ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus Data',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        axios.delete('api/gedung/'+id)
                        .then((response) => {
                            if (response.status == 200) {
                                Signal.$emit('load_gedung')
                                toast({
                                    type: 'success',
                                    title: response.data.message
                                })
                                this.$Progress.finish()
                            }
                        })
                        .catch((error) => {
                            this.$Progress.fail()
                            swal({
                                title: 'Gagal Menghapus Data!',
                                text: 'Gedung ini masih menyimpan arsip, pindahkan arsip sebelum menghapus gedung!',
                                type: 'error'
                            })
                            console.log(error)
                        })
                    }
                })
            }
        }
    }
</script>