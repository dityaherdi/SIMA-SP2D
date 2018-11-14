<template>
    <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <template v-else>
        <div class="row">
        <div class="col-8">
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
                 <tr v-if="isBoxEmpty">
                    <td class="text-center" colspan="4">
                        Data tidak ditemukan
                    </td>
                </tr>
                <tbody v-else>
                    <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Rak</th>
                        <th>Kode Box</th>
                        <th>Aksi</th>
                    </tr>
                    <tr v-for="(b,index) in box.data" :key="b.id_box">
                        <td>{{ ++index }}</td>
                        <td>{{ b.rak.ruangan.kode_ruangan }}</td>
                        <td>{{ b.rak.kode_rak }}</td>
                        <td>{{ b.kode_box | uppercase}}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                title="Lihat Detail Box"
                                @click="showDetailModal(b)">
                                <i class="fas fa-eye "></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                title="Edit Data Box"
                                @click="showEditingModal(b)">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" v-if="$store.state.currentUser.tipe === 'Master'"
                                title="Hapus Data Box"
                                @click="deleteBox(b.id_box)">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left" v-if="searching">
                    <button class="btn btn-success btn-sm" @click="loadBox()">
                        <i class="fas fa-list-alt mr-2"></i> Semua Box
                    </button>
                </div>
                <div class="float-right">
                    <pagination :data="box" @pagination-change-page="getResults" :limit="1"></pagination>
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
                        <select class="form-control" @change="selectRuangan" v-model="filters.selectedGed">
                            <option value=""> --- Semua Gedung --- </option>
                            <option v-for="ged in gedung" :key="ged.id_gedung" :value="ged.id_gedung">
                                {{ ged.nama_gedung }}
                            </option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <span id="boxEmptyInRua" class="red"></span>
                        <select class="form-control" v-model="filters.selectedRua" @change="selectRak"
                            :disabled="this.filters.selectedGed=='' ? true : false">
                            <option value=""> --- Semua Ruangan --- </option>
                            <option v-for="rua in ruangan"
                                :key="rua.id_ruangan"
                                :value="rua.id_ruangan">
                                {{ rua.kode_ruangan }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <span id="boxEmptyInRak" class="red"></span>
                        <select class="form-control" v-model="filters.selectedRak" @change="getBoxInRak"
                            :disabled="this.filters.selectedRua=='' ? true : false">
                            <option value=""> --- Semua Rak --- </option>
                            <option v-for="r in rak"
                                :key="r.id_rak"
                                :value="r.id_rak">
                                {{ r.kode_rak }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <modal-box></modal-box>
        <detail-box></detail-box>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                gedung: {},
                ruangan: {},
                rak: {},
                box: {},
                filters: {
                    selectedGed: '',
                    selectedRua: '',
                    selectedRak: '',
                },
                searching: false,
                boxKeyword: null
            }
        },

        created() {
            Signal.$on('/box-search', (keywords) => {
                this.boxKeyword = keywords
                this.searchBox(keywords)
            }),

            this.loadBox()
            Signal.$on('load_box', () => {
                this.loadBox()
            })

            if (this.isMasterOrAdmin()) {
                this.getGedung()
                .then((gedung) => {
                    this.gedung = gedung
                })  
            }
        },

        computed: {
            isBoxEmpty() {
                if (typeof this.box.data == 'undefined' && this.box!=null) {
                    return false
                }else if (typeof this.box.data != 'undefined' && this.box.data.length==0) {
                    return true
                }
            }
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
                if (this.isMasterOrAdmin()) {
                    this.readData('api/box')
                    .then((box) => {
                        this.box = box
                        this.searching = false
                        this.boxKeyword = null
                        this.filters.selectedGed = ''
                        this.filters.selectedRua = ''
                        this.filters.selectedRak = ''
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteBox(id) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/box/'+id, 'box')
                }
            },

            getResults(page = 1) {
                if (this.isMasterOrAdmin()) {
                    if (this.searching==true) {
                        axios.get('api/search-box?keywords='+this.boxKeyword+'&page='+page)
                        .then((response) => {
                            this.box = response.data.data
                        })
                    }else if (this.filters.selectedGed!='') {
                        axios.get('api/box-in-gedung/'+this.filters.selectedGed+'?page='+page)
                        .then((response) => {
                            this.box = response.data.data
                        })
                    }else if (this.filters.selectedRua!='') {
                        axios.get('api/box-in-ruangan/'+this.filters.selectedRua+'?page='+page)
                        .then((response) => {
                            this.box = response.data.data
                        })
                    }else if (this.filters.selectedRak!='') {
                        axios.get('api/box-in-rak/'+this.filters.selectedRak+'?page='+page)
                        .then((response) => {
                            this.box = response.data.data
                        })
                    }else{
                        axios.get('api/box?page='+page)
                        .then((response) => {
                            this.box = response.data.data
                        })
                    }
                }
            },

            searchBox(keywords) {
                if (this.isMasterOrAdmin()) {
                    this.searchData('api/search-box?keywords='+keywords)
                    .then((box) => {
                        this.box = box
                        this.searching = true
                    })
                }
            },

            selectRuangan() {
                this.getBoxInGedung()
                $('#boxEmptyInRua').text('')
                if (this.isMasterOrAdmin()) {
                    this.getRuangan(this.filters.selectedGed)
                    .then((ruangan) => {
                        if (ruangan.length==0) {
                            $('#boxEmptyInRua').text('Tidak ada ruangan')
                            this.ruangan = {}
                        } else {
                            this.ruangan = ruangan
                        }
                    })
                }
            },

            selectRak() {
                this.getBoxInRuangan()
                $('#boxEmptyInRak').text('')
                if (this.isMasterOrAdmin()) {
                    this.getRak(this.filters.selectedRua)
                    .then((rak) => {
                        if (rak.length==0) {
                            $('#boxEmptyInRak').text('Tidak ada rak')
                            this.rak = {}
                        } else {
                            this.rak = rak
                        }
                    })
                }
            },

            getBoxInRak() {
                if (this.isMasterOrAdmin()) {
                    if (this.filters.selectedGed=='' || this.filters.selectedRua=='' || this.filters.selectedRak=='') {
                        this.loadBox()
                    } else {
                        axios.get('api/box-in-rak/'+this.filters.selectedRak)
                        .then((box) => {
                            this.box = box.data.data
                        })
                    }
                }
            },

            getBoxInRuangan() {
                if (this.isMasterOrAdmin()) {
                    if (this.filters.selectedRua=='' || this.filters.selectedGed=='') {
                        this.loadBox()
                    }else {
                        axios.get('api/box-in-ruangan/'+this.filters.selectedRua)
                        .then((box) => {
                            this.box = box.data.data
                        })
                    }
                }
            },

            getBoxInGedung() {
                if (this.isMasterOrAdmin()) {
                    if (this.filters.selectedGed=='') {
                        this.loadBox()
                    }else {
                        axios.get('api/box-in-gedung/'+this.filters.selectedGed)
                        .then((box) => {
                            this.box = box.data.data
                        })
                    }
                }
            }
        }
    }
</script>