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
                  <tr v-for="ged in gedung.data" :key="ged.id_gedung">
                    <td>{{ ged.kode_gedung | uppercase}}</td>
                    <td>{{ ged.nama_gedung }}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Gedung"
                            @click="showDetailGedungModal(ged)">
                            <i class="fas fa-eye "></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Gedung"
                            @click="showEditingModal(ged)">
                            <i class="fas fa-edit"></i>
                        </a>
                        /
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
              <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <pagination :data="gedung" @pagination-change-page="getResults"></pagination>
                    </div>
              </div>
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
                this.readData('api/gedung')
                .then((gedung) => {
                    this.gedung = gedung
                })
            },

            deleteGedung(id) {
                this.deleteData('api/gedung/'+id, 'gedung')
            },

            getResults(page = 1) {
                axios.get('api/gedung?page='+page)
                .then((response) => {
                    this.gedung = response.data.data
                })
            }
        }
    }
</script>