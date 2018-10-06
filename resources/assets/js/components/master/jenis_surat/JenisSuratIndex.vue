<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-warning card-outline">
              <div class="card-header">
                <h3 class="card-title">Jenis SP2D</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Data Jenis SP2D">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                  <tr>
                    <th>Kode Jenis SP2D</th>
                    <th>Nama Jenis SP2D</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-for="jen in jenis" :key="jen.id_jenis_sp2d">
                    <td>{{ jen.kode_jenis_sp2d | uppercase}}</td>
                    <td>{{ jen.nama_jenis_sp2d }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Jenis SP2D"
                            @click="showDetailJenisModal(jen)">
                            <i class="fas fa-eye "></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Jenis SP2D"
                            @click="showEditingModal(jen)">
                            <i class="fas fa-edit"></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                            title="Hapus Data Jenis SP2D"
                            @click="deleteJenis(jen.id_jenis_sp2d)">
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
        <modal-jenis></modal-jenis>
        <detail-jenis></detail-jenis>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                jenis: {}
            }
        },

        created() {
            this.loadJenis()
            Signal.$on('load_jenis', () => {
                this.loadJenis();
            })
        },

        components: {
          "modal-jenis": require('./children/JenisSuratModal.vue'),
          "detail-jenis": require('./children/DetailJenisSuratModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_jenis_modal')
            },

            showEditingModal(jen) {
                Signal.$emit('show_editing_jenis_modal', jen)
            },

            showDetailJenisModal(jen) {
                Signal.$emit('show_detail_jenis_modal', jen)
            },

            loadJenis() {
                this.readData('api/jenis')
                .then((jenis) => {
                    this.jenis = jenis.data
                })
            },

            deleteJenis(id) {
                this.deleteData('api/jenis/'+id, 'jenis')
            }
        }
    }
</script>