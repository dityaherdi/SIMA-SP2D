<template>
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Box Arsip</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Box">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                  <tr>
                    <th>No</th>
                    <th>Rak</th>
                    <th>Kode Box</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-for="(b,index) in box.data" :key="b.id_box">
                    <td>{{ ++index }}</td>
                    <td>{{ b.rak.kode_rak }}</td>
                    <td>{{ b.kode_box | uppercase}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                            title="Lihat Detail Box"
                            @click="showDetailModal(b)">
                            <i class="fas fa-eye "></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                            title="Edit Data Box"
                            @click="showEditingModal(b)">
                            <i class="fas fa-edit"></i>
                        </a>
                        /
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                            title="Hapus Data Box"
                            @click="deleteBox(b.id_box)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <pagination :data="box" @pagination-change-page="getResults"></pagination>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <modal-box></modal-box>
        <detail-box></detail-box>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                box: {}
            }
        },

        created() {
            this.loadBox()
            Signal.$on('load_box', () => {
                this.loadBox()
            })
        },

        components: {
          "modal-box": require('./children/BoxModal.vue'),
          "detail-box": require('./children/DetailBoxModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_box_modal')
            },

            showEditingModal(b) {
                Signal.$emit('show_editing_box_modal', b)
            },

            showDetailModal(b) {
                Signal.$emit('show_detail_box_modal', b)
            },

            loadBox() {
                this.readData('api/box')
                .then((box) => {
                    this.box = box
                })
            },

            deleteBox(id) {
                this.deleteData('api/box/'+id, 'box')
            },

            getResults(page = 1) {
                axios.get('api/box?page='+page)
                .then((response) => {
                    this.box = response.data.data
                })
            }
        }
    }
</script>