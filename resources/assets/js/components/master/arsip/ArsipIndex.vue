<template>
    <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <div class="content" v-if="arsip.length==0">
            <div class="alert alert-danger col-12" role="alert">
                <h5><i class="icon fa fa-ban"></i> Data tidak ditemukan!</h5>
                <p>Tidak terdapat data arsip atau hasil pencarian tidak ditemukan.</p>
                <button class="btn btn-outline-light btn-sm" @click="loadArsip">
                    <i class="fas fa-list-alt mr-2"></i> Semua Arsip
                </button>
            </div>
        </div>

        <div class="content" v-if="searchResult">
            <div class="alert alert-success col-12" role="alert">
                <h5><i class="icon fa fa-check"></i> Hasil pencarian : '{{ arsipKeyword }}'</h5>
                <button class="btn btn-outline-light btn-sm" @click="loadArsip">
                    <i class="fas fa-list-alt mr-2"></i> Semua Arsip
                </button>
            </div>
        </div>

        <template v-if="arsip.length!=0">
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
                    <router-link :to="{ name: 'Retensi' }" class="btn btn-outline-danger">
                        <i class="fas fa-calendar-times mr-2"></i> Retensi Tahunan
                    </router-link>
                </li>
                <li class="nav-item mr-3 mb-3 mt-3">
                    <router-link :to="{ name: 'Bukti' }" class="btn btn-outline-success">
                        <i class="fas fa-gavel mr-2"></i> Penggunaan Bukti Autentik
                    </router-link>
                </li>
            </ul>
        </nav>
        <ul class="list-group mt-3">
            <li class="list-group-item list-group-item-action" v-for="(ars,index) in sortedArsip(arsip)" :key="ars.id_arsip">
                <span class="mr-3">{{ ++index }}</span>
                <span :class="bgColor(ars.surat.jenis.kode_jenis_sp2d)" class="mr-2">
                    <i class="fas fa-file-archive"></i>
                </span>
                {{ ars.surat.nomor_surat }}
                <button class="btn btn-danger btn-sm float-right ml-2" @click="retensi(ars)">
                    <i class="fas fa-eraser"></i> Retensi
                </button>
                <button class="btn btn-success btn-sm float-right ml-2" @click="showEditingModal(ars)">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-primary btn-sm float-right ml-2" @click="showDetailModal(ars)">
                    <i class="fas fa-eye"></i> Detail
                </button>
            </li>
        </ul>
        </template>
        <modal-arsip></modal-arsip>
        <detail-arsip></detail-arsip>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                skpd:{},
                arsip: {},
                next: null,
                loadable: true,
                searching: false,
                arsipKeyword: null,
                sorting: {
                    key: '',
                    val: ''
                },
                selectedSkpd: '',
                arsipBySkpd: {}
            }
        },

        created() {
            Signal.$on('/arsip-search', (keywords) => {
                this.arsipKeyword = keywords
                this.searchArsip(keywords)
            }),

            this.loadArsip()
            Signal.$on('load_arsip', () => {
                this.loadArsip()
            })

            if (this.isMasterOrAdmin()) {
                this.getSkpd()
                .then((skpd) => {
                    this.skpd = skpd
                })
            }
        },

        mounted() {
            if (this.loadable==true) {
                this.loadMoreArsip()
            }
        },

        components: {
          "modal-arsip": require('./children/ArsipModal.vue'),
          "detail-arsip": require('./children/DetailArsipModal.vue')
        },

        computed: {
            searchResult() {
                return this.arsip.length != 0 && this.searching == true
            }
        },
        
        methods: {
            showEditingModal(ars) {
                Signal.$emit('show_editing_arsip_modal', ars)
            },

            showDetailModal(ars) {
                Signal.$emit('show_detail_arsip_modal', ars)
            },

            retensi(ars) {
                if (this.isMasterOrAdmin()) {
                    this.deleteData('api/arsip/'+ars.id_arsip, 'arsip')
                }
            },

            loadArsip() {
                if (this.isMasterOrAdmin()) {
                    this.readData('api/arsip')
                    .then((arsip) => {
                        this.loadable = true
                        this.arsip = arsip.data
                        this.next = arsip.next_page_url
                        this.searching = false
                        this.arsipKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            bgColor(jenis) {
                if (jenis=='UP') {
                    return 'badge badge-primary'
                }else if(jenis=='GU'){
                    return 'badge badge-success'
                }else if(jenis=='TU'){
                    return 'badge badge-danger'
                }else if(jenis=='LS'){
                    return 'badge badge-warning'
                }
            },

            loadMoreArsip() {
                if (this.isMasterOrAdmin()) {
                    window.onscroll = () => {
                        let bottom = 
                            document.documentElement.scrollTop + window.innerHeight 
                            === 
                            document.documentElement.offsetHeight
    
                        if (bottom && this.loadable == true && this.$route.path == '/arsip') {
                            if (this.next==null) {
                                this.loadable=false
                                swal({
                                    title: 'Anda sudah di halaman terakhir',
                                    text: 'Tidak ada data lagi untuk ditampilkan',
                                    type: 'info'
                                })
                            }else {
                                if (this.searching==true) {
                                    axios.get(this.next+'&keywords='+this.arsipKeyword)
                                    .then((response) => {
                                        this.arsip = this.arsip.concat(Object.values(response.data.data.data))
                                        this.next = response.data.data.next_page_url
                                    })
                                } else if (this.sorting.key=='skpd' && this.sorting.val != '') {
                                    axios.get(this.next)
                                    .then((response) => {
                                        this.arsipBySkpd = this.arsip.concat(Object.values(response.data.data.data))
                                        this.next = response.data.data.next_page_url
                                    })
                                } else {
                                    axios.get(this.next)
                                    .then((response) => {
                                        this.arsip = this.arsip.concat(Object.values(response.data.data.data))
                                        this.next = response.data.data.next_page_url
                                    })
                                }
                            }
                        }
                    }
                }
            },

            searchArsip(keywords) {
                if (this.isMasterOrAdmin()) {
                    this.searchData('api/search-arsip?keywords='+keywords)
                    .then((arsip) => {
                        this.arsip = arsip.data
                        this.searching = true
                        this.next = arsip.next_page_url
                    })
                }
            },

            sort(key, val) {
                this.sorting.key = key
                this.sorting.val = val
                if (key=='skpd') {
                    if (val!='') {
                        axios.get('api/arsip-by-skpd/'+this.selectedSkpd)
                        .then((response) => {
                            this.next = response.data.data.next_page_url
                            this.arsip = response.data.data.data
                        })
                    }else {
                        this.loadArsip()
                    }
                }
            },

            sortedArsip(arsip) {
                if (this.sorting.key=='' && this.sorting.val=='') {
                    return arsip
                }else if (this.sorting.key == 'skpd') {
                    if (this.sorting.val == '') {
                        return arsip
                    }else {
                        return this.arsip
                    }
                }
            }
        }
    }
</script>