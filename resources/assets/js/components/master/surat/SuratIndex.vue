<template>
    <div>
        <not-found v-if="!isMasterOrAdmin()"></not-found>
        <template v-else>
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-3">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="#">Centered nav only <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-primary mb-3" @click="showCreatingModal()">
                        Tambah Data SP2D
                    </button>
                </li>
            </ul>
            </div>
        </nav>
        
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12" v-for="(sur,index) in surat" :key="sur.id_sp2d">
                <div class="info-box"
                    :class="bgColor(sur.jenis.kode_jenis_sp2d)">
                <span>{{ ++index }}</span>
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
                surat: {},
                next: null,
                loadable: true
            }
        },

        mounted() {
            if (this.loadable==true) {
                this.loadMoreSurat()
            }
        },

        created() {
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
        }
    }
</script>