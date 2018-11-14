<template>
    <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <template v-else>
        <div class="row">
        <div class="col-8">
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
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                <tr v-if="isRuanganEmpty">
                    <td class="text-center" colspan="4">
                        Data tidak ditemukan
                    </td>
                </tr>
                <tbody v-else>
                    <tr>
                        <th>No</th>
                        <th>Gedung</th>
                        <th>Kode Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                    <tr v-for="(rua,index) in ruangan.data" :key="rua.id_ruangan">
                        <td>{{ ++index }}</td>
                        <td>{{ rua.gedung.nama_gedung }}</td>
                        <td>{{ rua.kode_ruangan | uppercase}}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                title="Lihat Detail Ruangan"
                                @click="showDetailRuanganModal(rua)">
                                <i class="fas fa-eye "></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                title="Edit Data Ruangan"
                                @click="showEditingModal(rua)">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" v-if="$store.state.currentUser.tipe === 'Master'"
                                title="Hapus Data Ruangan"
                                @click="deleteRuangan(rua.id_ruangan)">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left" v-if="searching">
                    <button class="btn btn-success btn-sm" @click="loadRuangan()">
                        <i class="fas fa-list-alt mr-2"></i> Semua Ruangan
                    </button>
                </div>
                <div class="float-right">
                    <pagination :data="ruangan" @pagination-change-page="getResults" :limit="1"></pagination>
                </div>
            </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    Seleksi Penyimpanan
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <select class="form-control" @change="getRuanganInGedung" v-model="selectedGed">
                            <option value=""> --- Semua Gedung --- </option>
                            <option v-for="ged in gedung" :key="ged.id_gedung" :value="ged.id_gedung">
                                {{ ged.nama_gedung }}
                            </option>
                        </select>
                    </div> 
                </div>
            </div>
        </div>
        </div>
        <modal-ruangan></modal-ruangan>
        <detail-ruangan></detail-ruangan>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gedung: {},
                selectedGed: '',
                ruangan: {},
                searching: false,
                ruaKeyword: null
            }
        },

        created() {
            Signal.$on('/ruangan-search', (keywords) => {
                this.ruaKeyword = keywords
                this.searchRuangan(keywords)
            }),

            this.loadRuangan()
            Signal.$on('load_ruangan', () => {
                this.loadRuangan();
            })

            if (this.isMasterOrAdmin()) {
                this.getGedung()
                .then((gedung) => {
                    this.gedung = gedung
                })  
            }
        },

        computed: {
            isRuanganEmpty() {
                if (typeof this.ruangan.data == 'undefined' && this.ruangan!=null) {
                    return false
                }else if (typeof this.ruangan.data != 'undefined' && this.ruangan.data.length==0) {
                    return true
                }
            }
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
                if (this.isMasterOrAdmin()) {
                    this.readData('api/ruangan')
                    .then((ruangan) => {
                        this.ruangan = ruangan
                        this.searching = false
                        this.ruaKeyword = null
                        this.selectedGed = ''
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteRuangan(id) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/ruangan/'+id, 'ruangan')
                }
            },

            getResults(page = 1) {
                if (this.isMasterOrAdmin()) {
                    if (this.searching==true) {
                        axios.get('api/search-ruangan?keywords='+this.ruaKeyword+'&page='+page)
                        .then((response) => {
                            this.ruangan = response.data.data
                        })
                    } if (this.selectedGed!='') {
                        axios.get('api/ruangan-in-gedung/'+this.selectedGed+'?page='+page)
                        .then((response) => {
                            this.ruangan = response.data.data
                        })
                    } else {
                        axios.get('api/ruangan?page='+page)
                        .then((response) => {
                            this.ruangan = response.data.data
                        })
                    }
                }
            },

            searchRuangan(keywords) {
                if (this.isMasterOrAdmin()) {
                    this.searchData('api/search-ruangan?keywords='+keywords)
                    .then((ruangan) => {
                        this.ruangan = ruangan
                        this.searching = true
                    })
                }
            },

            getRuanganInGedung() {
                if (this.isMasterOrAdmin()) {
                    if (this.selectedGed=='') {
                        this.loadRuangan()
                    } else {
                        axios.get('api/ruangan-in-gedung/'+this.selectedGed)
                        .then((ruangan) => {
                            this.ruangan = ruangan.data.data
                        })
                    }
                }
            }
        }
    }
</script>