<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Rak Arsip</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Rak">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                  <tr>
                    <th>Ruangan</th>
                    <th>Kode Rak</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-for="r in rak" :key="r.id_rak">
                    <!-- <td>{{ r.ruangan.gedung.nama_gedung }}</td> -->
                    <td>{{ r.ruangan.kode_ruangan }}</td>
                    <td>{{ r.kode_rak | uppercase}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Rak"
                            @click="showDetailRakModal(r)">
                            <i class="fas fa-eye "></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Rak"
                            @click="showEditingModal(r)">
                            <i class="fas fa-edit"></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                            title="Hapus Data Rak"
                            @click="deleteRak(r.id_rak)">
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
        <modal-rak></modal-rak>
        <detail-rak></detail-rak>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                rak: {}
            }
        },

        created() {
            this.loadRak()
            Signal.$on('load_rak', () => {
                this.loadRak();
            })
        },

        components: {
          "modal-rak": require('./children/RakModal.vue'),
          "detail-rak": require('./children/DetailRakModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_rak_modal')
            },

            showEditingModal(r) {
                Signal.$emit('show_editing_rak_modal', r)
            },

            showDetailRakModal(r) {
                Signal.$emit('show_detail_rak_modal', r)
            },

            loadRak() {
                this.readData('api/rak')
                .then((rak) => {
                    this.rak = rak.data
                })
            },

            deleteRak(id) {
                this.deleteData('api/rak/'+id, 'rak')
            }
        }
    }
</script>