<template>
    <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <template v-else>
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
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                <tr v-if="isGedungEmpty">
                    <td class="text-center" colspan="4">
                        Data tidak ditemukan
                    </td>
                </tr>
                <tbody v-else>
                    <tr>
                        <th>No</th>
                        <th>Kode Gedung</th>
                        <th>Nama Gedung</th>
                        <th>Aksi</th>
                    </tr>
                    <tr v-for="(ged,index) in gedung.data" :key="ged.id_gedung">
                        <td>{{ index + counter }}</td>
                        <td>{{ ged.kode_gedung | uppercase}}</td>
                        <td>{{ ged.nama_gedung }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                title="Lihat Detail Gedung"
                                @click="showDetailGedungModal(ged)">
                                <i class="fas fa-eye "></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                title="Edit Data Gedung"
                                @click="showEditingModal(ged)">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" v-if="$store.state.currentUser.tipe === 'Master'"
                                title="Hapus Data Gedung"
                                @click="deleteGedung(ged.id_gedung)">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left" v-if="searching">
                    <button class="btn btn-success btn-sm" @click="loadGedung()">
                        <i class="fas fa-list-alt mr-2"></i> Semua Gedung
                    </button>
                </div>
                <div class="float-right">
                    <pagination :data="gedung" @pagination-change-page="getResults" :limit="1"></pagination>
                </div>
            </div>
            </div>
        </div>
        </div>
        <modal-gedung></modal-gedung>
        <detail-gedung></detail-gedung>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gedung: {},
                counter: 0,
                searching: false,
                gedKeyword: null
            }
        },

        created() {
            Signal.$on('/gedung-search', (keywords) => {
                this.gedKeyword = keywords
                this.searchGedung(keywords)
            }),

            this.loadGedung()
            Signal.$on('load_gedung', () => {
                this.loadGedung();
            })
        },

        computed: {
            isGedungEmpty() {
                if (typeof this.gedung.data == 'undefined' && this.gedung!=null) {
                    return false
                }else if (typeof this.gedung.data != 'undefined' && this.gedung.data.length==0) {
                    return true
                }
            }
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
                if (this.isMasterOrAdmin()) {
                    this.readData('api/gedung')
                    .then((gedung) => {
                        this.gedung = gedung
                        this.counter = gedung.from
                        this.searching = false
                        this.gedKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteGedung(id) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/gedung/'+id, 'gedung')
                }
            },

            getResults(page = 1) {
                if (this.isMasterOrAdmin()) {
                    if (this.searching==true) {
                        axios.get('api/search-gedung?keywords='+this.gedKeyword+'&page='+page)
                        .then((response) => {
                            this.gedung = response.data.data
                            this.counter = response.data.data.from
                        })
                    }else{
                        axios.get('api/gedung?page='+page)
                        .then((response) => {
                            this.gedung = response.data.data
                            this.counter = response.data.data.from
                        })
                    }
                }
            },

            searchGedung(keywords) {
                if (this.isMaster()) {
                    this.searchData('api/search-gedung?keywords='+keywords)
                    .then((gedung) => {
                        this.gedung = gedung
                        this.searching = true
                    })
                }
            }
        }
    }
</script>