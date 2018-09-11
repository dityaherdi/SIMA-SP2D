<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">SKPD</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-primary" @click="showCreatingModal" 
                    title="Tambah Data SKPD">
                    <i class="fas fa-plus-square"></i>
                </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Kode SKPD</th>
                            <th>SKPD</th>
                            <th>Aksi</th>
                        </tr>
                        <tr v-for="skpd in skpds" :key="skpd.id">
                            <td>{{ skpd.kode_skpd }}</td>
                            <td>{{ skpd.alias_skpd }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                    title="Lihat Detail SKPD"
                                    @click="showDetailSkpdModal(skpd)">
                                    <i class="fas fa-eye "></i>
                                </a>
                                |
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                    title="Edit Data SKPD"
                                    @click="showEditingModal(skpd)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                |
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                                    title="Hapus Data SKPD"
                                    @click="deleteSkpd(skpd.id)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <modal-skpd></modal-skpd>
        <detail-skpd></detail-skpd>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                skpds: {}
            }
        },
        created() {
            this.loadSkpd(),
            Signal.$on('load_skpd', () => {
                this.loadSkpd()
            })
        },

        components: {
          "modal-skpd": require('./children/SkpdModal.vue'),
          "detail-skpd": require('./children/DetailSkpdModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_skpd_modal')
            },
            showEditingModal(skpd) {
                Signal.$emit('show_editing_skpd_modal', skpd)
            },
            showDetailSkpdModal(skpd) {
                Signal.$emit('show_detail_skpd_modal', skpd)
            },
            loadSkpd() {
                axios.get('api/skpd')
                .then((response) => {
                    this.skpds = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },
            deleteSkpd(id) {
                swal({
                    title: 'Hapus Data ini?',
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
                        axios.delete('api/skpd/'+id)
                        .then((response) => {
                            if (response.status == 200) {
                                Signal.$emit('load_skpd')
                                toast({
                                    type: 'success',
                                    title: response.data.message
                                })
                                this.$Progress.finish()
                            }
                        })
                        .catch((error) => {
                            swal({
                                title: 'Error!',
                                text: 'Terjadi kesalahan',
                                type: 'error'
                            })
                            this.$Progress.fail()
                        })
                    }
                })
            }
        }
    }
</script>