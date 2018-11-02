<template>
    <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <template v-else>
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
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                 <tr v-if="isRakEmpty">
                    <td class="text-center" colspan="4">
                        Data tidak ditemukan
                    </td>
                </tr>
                <tbody v-else>
                    <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Kode Rak</th>
                        <th>Aksi</th>
                    </tr>
                    <tr v-for="(r,index) in rak.data" :key="r.id_rak">
                        <td>{{ ++index }}</td>
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
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left" v-if="searching">
                    <button class="btn btn-success btn-sm" @click="loadRak()">
                        <i class="fas fa-list-alt mr-2"></i> Semua Rak
                    </button>
                </div>
                <div class="float-right">
                    <pagination :data="rak" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
            </div>
        </div>
        </div>
        <modal-rak></modal-rak>
        <detail-rak></detail-rak>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                rak: {},
                searching: false,
                rakKeyword: null
            }
        },

        created() {
            Signal.$on('/rak-search', (keywords) => {
                this.rakKeyword = keywords
                this.searchRak(keywords)
            }),

            this.loadRak()
            Signal.$on('load_rak', () => {
                this.loadRak();
            })
        },

        computed: {
            isRakEmpty() {
                if (typeof this.rak.data == 'undefined' && this.rak!=null) {
                    return false
                }else if (typeof this.rak.data != 'undefined' && this.rak.data.length==0) {
                    return true
                }
            }
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
                if (this.isMasterOrAdmin()) {
                    this.readData('api/rak')
                    .then((rak) => {
                        this.rak = rak
                        this.searching = false
                        this.rakKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteRak(id) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/rak/'+id, 'rak')
                }
            },

            getResults(page = 1) {
                if (this.isMasterOrAdmin()) {
                    if (this.searching==true) {
                        axios.get('api/search-rak?keywords='+this.rakKeyword+'&page='+page)
                        .then((response) => {
                            this.rak = response.data.data
                        })
                    }else {
                        axios.get('api/rak?page='+page)
                        .then((response) => {
                            this.rak = response.data.data
                        })
                    }
                }
            },

            searchRak(keywords) {
                if (this.isMaster()) {
                    this.searchData('api/search-rak?keywords='+keywords)
                    .then((rak) => {
                        this.rak = rak
                        this.searching = true
                    })
                }
            }
        }
    }
</script>