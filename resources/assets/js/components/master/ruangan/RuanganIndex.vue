<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Ruangan Arsip</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Ruangan">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                  <tr>
                    <th>Gedung</th>
                    <th>Kode Ruangan</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-for="rua in ruangan.data" :key="rua.id_ruangan">
                    <td>{{ rua.gedung.nama_gedung }}</td>
                    <td>{{ rua.kode_ruangan | uppercase}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Ruangan"
                            @click="showDetailRuanganModal(rua)">
                            <i class="fas fa-eye "></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Ruangan"
                            @click="showEditingModal(rua)">
                            <i class="fas fa-edit"></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                            title="Hapus Data Ruangan"
                            @click="deleteRuangan(rua.id_ruangan)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <pagination :data="ruangan" @pagination-change-page="getResults"></pagination>
                    </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->
        <modal-ruangan></modal-ruangan>
        <detail-ruangan></detail-ruangan>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ruangan: {}
            }
        },

        created() {
            this.loadRuangan()
            Signal.$on('load_ruangan', () => {
                this.loadRuangan();
            })
        },

        components: {
          "modal-ruangan": require('./children/RuanganModal.vue'),
          "detail-ruangan": require('./children/DetailRuanganModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_ruangan_modal')
            },

            showEditingModal(rua) {
                Signal.$emit('show_editing_ruangan_modal', rua)
            },

            showDetailRuanganModal(rua) {
                Signal.$emit('show_detail_ruangan_modal', rua)
            },

            loadRuangan() {
                this.readData('api/ruangan')
                .then((ruangan) => {
                    this.ruangan = ruangan
                })
            },

            deleteRuangan(id) {
                this.deleteData('api/ruangan/'+id, 'ruangan')
            },

            getResults(page = 1) {
                axios.get('api/ruangan?page='+page)
                .then((response) => {
                    this.ruangan = response.data.data
                })
            }
        }
    }
</script>