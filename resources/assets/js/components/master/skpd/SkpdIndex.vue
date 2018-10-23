<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h3 class="card-title">Satuan Kerja Perangkat Daerah</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal" 
                        title="Tambah Data SKPD">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>No</th>
                            <th>Kode SKPD</th>
                            <th>SKPD</th>
                            <th>Aksi</th>
                        </tr>
                        <tr v-for="(skpd,index) in skpds.data" :key="skpd.id_skpd">
                            <td>{{ index + counter }}</td>
                            <td>{{ skpd.kode_skpd }}</td>
                            <td>{{ skpd.alias_skpd }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                    title="Lihat Detail SKPD"
                                    @click="showDetailSkpdModal(skpd)">
                                    <i class="fas fa-eye "></i>
                                </a>
                                /
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                    title="Edit Data SKPD"
                                    @click="showEditingModal(skpd)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                                    title="Hapus Data SKPD"
                                    @click="deleteSkpd(skpd.id_skpd)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <pagination :data="skpds" @pagination-change-page="getResults"></pagination>
                    </div>
              </div>
            </div>
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
                skpds: {},
                counter: 0
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
                this.readData('api/skpd')
                .then((skpd) => {
                    this.skpds = skpd
                    this.counter = skpd.from
                })
            },

            deleteSkpd(id) {
                this.deleteData('api/skpd/'+id, 'skpd')
            },
            
            getResults(page = 1) {
                axios.get('api/skpd?page='+page)
                .then((response) => {
                    this.skpds = response.data.data
                    this.counter = response.data.data.from
                })
            }
            
        }
    }
</script>