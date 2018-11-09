<template>
    <div>
        <not-found v-if="!isMasterOrAdmin()"></not-found>
        <template v-else>
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-3">
            <ul class="navbar-nav">
                <li class="nav-item mr-3 mb-3 mt-3">
                    <div class="form-group">
                        <select class="form-control" v-model="selectedSkpd" @change="sort('skpd', selectedSkpd)">
                            <option :value="''"> --- Semua SKPD --- </option>
                            <option v-for="s in skpd" :key="s.id_skpd" :value="s.id_skpd"> 
                                {{ s.nama_skpd }}
                            </option>
                        </select>
                    </div>
                </li>
                <li class="nav-item mr-3 mb-3 mt-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"> <i class="fas fa-info-circle mr-2"></i>
                            Info Warna
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0)" @click="sort('jenis', 'UP')">
                                <span class="badge badge-primary mr-2">
                                    <i class="fas fa-envelope-open"></i> 
                                </span> UP - Uang Persediaan
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="sort('jenis', 'GU')">
                                <span class="badge badge-success mr-2">
                                    <i class="fas fa-envelope-open"></i> 
                                </span> GU - Ganti Uang
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="sort('jenis', 'TU')">
                                <span class="badge badge-danger mr-2">
                                    <i class="fas fa-envelope-open"></i> 
                                </span> TU - Tambah Uang
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="sort('jenis', 'LS')">
                                <span class="badge badge-warning mr-2">
                                    <i class="fas fa-envelope-open"></i> 
                                </span> LS - Lumpsump
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="sort('', '')">
                                Semua Jenis SP2D
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item mr-3 mb-3 mt-3">
                    <button type="button" class="btn btn-success" @click="showCreatingModal()">
                        <i class="fas fa-plus-square mr-2"></i>
                        Tambah Data SP2D
                    </button>
                </li>
            </ul>
        </nav>
        <div class="content" v-if="surat.length==0">
            <div class="alert alert-danger col-12" role="alert">
                <h5><i class="icon fa fa-ban"></i> Data tidak ditemukan!</h5>
                <p>Tidak terdapat data surat atau hasil pencarian tidak ditemukan.</p>
                <button class="btn btn-outline-light btn-sm" @click="loadSurat">
                    <i class="fas fa-list-alt mr-2"></i> Semua Surat
                </button>
            </div>
        </div>

        <div class="content" v-if="searchResult">
            <div class="alert alert-success col-12" role="alert">
                <h5><i class="icon fa fa-check"></i> Hasil pencarian : '{{ suratKeyword }}'</h5>
                <button class="btn btn-outline-light btn-sm" @click="loadSurat">
                    <i class="fas fa-list-alt mr-2"></i> Semua Surat
                </button>
            </div>
        </div>

        <div class="row" v-if="surat.length!=0">
            <div class="col-md-3 col-sm-6 col-12" v-for="(sur,index) in sortedSurat(surat)" :key="sur.id_sp2d">
                <div class="info-box"
                    :class="bgColor(sur.jenis.kode_jenis_sp2d)">
                
                <span class="info-box-icon"><i class="fas fa-envelope-open"></i></span>
                
                <div class="info-box-content">
                    
                    <span class="info-box-text" style="font-size:13px;">{{ sur.nomor_surat }}</span>
                    <span class="info-box-text">{{ sur.tgl_terbit | tanggalLokal }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        <div class="btn-group float-right">
                            <button class="btn btn-dark btn-sm" title="Lihat Detail Surat"
                                @click="showDetailModal(sur)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-dark btn-sm" title="Edit Surat"
                                @click="showEditingModal(sur)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-dark btn-sm" title="Hapus Surat"
                                @click="deleteSurat(sur.id_sp2d)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-dark btn-sm" title="Arsipkan Surat"
                                @click="showArchiveModal(sur)">
                                <i class="fas fa-file-archive"></i>
                            </button>
                        </div>
                        <div class="float-left">{{ ++index }}</div>
                    </span>
                </div>
                </div>
            </div>
        </div>
        <modal-surat></modal-surat>
        <detail-surat></detail-surat>
        <modal-arsip></modal-arsip>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                skpd:{},
                surat: {},
                next: null,
                loadable: true,
                searching: false,
                suratKeyword: null,
                sorting: {
                    key: '',
                    val: ''
                },
                selectedSkpd: ''
            }
        },

        mounted() {
            if (this.loadable==true) {
                this.loadMoreSurat()
            }
        },

        created() {
            Signal.$on('/surat-search', (keywords) => {
                this.suratKeyword = keywords
                this.searchSurat(keywords)
            }),

            this.loadSurat()
            Signal.$on('load_surat', () => {
                this.loadSurat()
                this.loadable = true
                this.loadMoreSurat()
            }),

            Signal.$on('load_arsip', () => {
                this.loadSurat()
                this.loadable = true
                this.loadMoreSurat()
            })

            if (this.isMasterOrAdmin()) {
                this.getSkpd()
                .then((skpd) => {
                    this.skpd = skpd
                })
            }

        },

        computed: {
            searchResult() {
                return this.surat.length != 0 && this.searching == true
            }
        },

        components: {
            "modal-surat": require('./children/SuratModal.vue'),
            "detail-surat": require('./children/DetailSuratModal.vue'),
            "modal-arsip": require('./../arsip/children/ArsipModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_surat_modal')
            },

            showEditingModal(sur) {
                Signal.$emit('show_editing_surat_modal', sur)
            },

            showDetailModal(sur) {
                Signal.$emit('show_detail_surat_modal', sur)
            },

            showArchiveModal(sur) {
                Signal.$emit('show_creating_arsip_modal', sur)
            },

            bgColor(jenis) {
                if (jenis=='UP') {
                    return 'bg-primary'
                }else if(jenis=='GU'){
                    return 'bg-success'
                }else if(jenis=='TU'){
                    return 'bg-danger'
                }else if(jenis=='LS'){
                    return 'bg-warning'
                }
            },

            loadSurat() {
                if (this.isMasterOrAdmin()) {
                    this.readData('api/surat')
                    .then((surat) => {
                        this.loadable = true
                        this.surat = surat.data
                        this.next = surat.next_page_url
                        this.searching = false
                        this.suratKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            deleteSurat(id) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/surat/'+id, 'surat')
                }
            },

            loadMoreSurat () {
                if (this.isMasterOrAdmin()) {
                    window.onscroll = () => {
                        let bottom = 
                            document.documentElement.scrollTop + window.innerHeight 
                            === 
                            document.documentElement.offsetHeight
    
                        if (bottom && this.loadable == true && this.$route.path == '/surat') {
                            if (this.next==null) {
                                this.loadable = false
                                swal({
                                    title: 'Anda sudah di halaman terakhir',
                                    text: 'Tidak ada data lagi untuk ditampilkan',
                                    type: 'info'
                                })
                            }else {
                                if (this.searching==true) {
                                    axios.get(this.next+'&keywords='+this.suratKeyword)
                                    .then((response) => {
                                        this.surat = this.surat.concat(Object.values(response.data.data.data))
                                        this.next = response.data.data.next_page_url
                                    })
                                } else {
                                    axios.get(this.next)
                                    .then((response) => {
                                        this.surat = this.surat.concat(Object.values(response.data.data.data))
                                        this.next = response.data.data.next_page_url
                                    })
                                }
                            }
                        }
                    }
                }
            },

            searchSurat(keywords) {
                if (this.isMasterOrAdmin()) {
                    this.searchData('api/search-surat?keywords='+keywords)
                    .then((surat) => {
                        this.surat = surat.data
                        this.searching = true
                        this.next = surat.next_page_url
                    })
                }
            },

            sort(key, val) {
                this.sorting.key = key
                this.sorting.val = val
            },

            sortedSurat(surat) {
                if (this.sorting.key=='' && this.sorting.val=='') {
                    return surat
                }else if (this.sorting.key == 'jenis') {
                    return _.pickBy(surat, { jenis: { kode_jenis_sp2d: this.sorting.val } })
                }else if (this.sorting.key == 'skpd') {
                    if (this.sorting.val == '') {
                        return surat
                    }else {
                        return _.pickBy(surat, { id_skpd: this.sorting.val })
                    }
                }
            }
        }
    }
</script>