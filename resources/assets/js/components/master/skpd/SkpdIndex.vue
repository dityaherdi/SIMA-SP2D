<template>
    <div>
        <not-found v-if="!this.isMaster()"></not-found>
        <template v-else>
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
                    <tr v-if="isSkpdEmpty">
                        <td class="text-center" colspan="4">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    <tbody v-else>
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
                    <div class="float-left" v-if="searching">
                        <button class="btn btn-success btn-sm" @click="loadSkpd()">
                            <i class="fas fa-list-alt mr-2"></i> Semua SKPD
                        </button>
                    </div>
                    <div class="float-right">
                        <pagination :data="skpds" @pagination-change-page="getResults"></pagination>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <modal-skpd></modal-skpd>
        <detail-skpd></detail-skpd>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                skpds: {},
                counter: 0,
                searching: false,
                skpdKeyword: null
            }
        },

        created() {
            Signal.$on('/skpd-search', (keywords) => {
                this.skpdKeyword = keywords
                this.searchSkpd(keywords)
            }),

            this.loadSkpd(),
            Signal.$on('load_skpd', () => {
                this.loadSkpd()
            })
        },

        computed: {
            isSkpdEmpty() {
                if (typeof this.skpds.data == 'undefined' && this.skpds!=null) {
                    return false
                }else if (typeof this.skpds.data != 'undefined' && this.skpds.data.length==0) {
                    return true
                }
            }
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
                if (this.isMaster()) {
                    this.readData('api/skpd')
                    .then((skpd) => {
                        this.skpds = skpd
                        this.counter = skpd.from
                        this.searching = false
                        this.skpdKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteSkpd(id) {
                if (this.isMaster()) {
                    this.deleteData('api/skpd/'+id, 'skpd')
                }
            },
            
            getResults(page = 1) {
                if (this.isMaster()) {
                    if (this.searching==true) {
                        axios.get('api/search-skpd?keywords='+this.skpdKeyword+'&page='+page)
                        .then((response) => {
                            this.skpds = response.data.data
                            this.counter = response.data.data.from
                        })
                    } else {
                        axios.get('api/skpd?page='+page)
                        .then((response) => {
                            this.skpds = response.data.data
                            this.counter = response.data.data.from
                        })
                    }
                }
            },

            searchSkpd(keywords) {
                if (this.isMaster()) {
                    this.searchData('api/search-skpd?keywords='+keywords)
                    .then((skpd) => {
                        this.skpds = skpd
                        this.searching = true
                    })
                }
            }
            
        }
    }
</script>