<template>
    <div>
        <not-found v-if="!isMaster()"></not-found>
        <template v-else>
        <div class="row">
        <div class="col-12">
            <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Jenis SP2D</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal"
                        title="Tambah Data Jenis SP2D">
                        <i class="fas fa-plus-square mr-2"></i> Tambah Jenis SP2D
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                <tr v-if="isJenisEmpty">
                    <td class="text-center" colspan="4">
                        Data tidak ditemukan
                    </td>
                </tr>
                <tbody v-else>
                    <tr>
                        <th>No</th>
                        <th>Kode Jenis SP2D</th>
                        <th>Nama Jenis SP2D</th>
                        <th>Aksi</th>
                    </tr>
                    <tr v-for="(jen,index) in jenis.data" :key="jen.id_jenis_sp2d">
                        <td>{{ index + counter }}</td>
                        <td>{{ jen.kode_jenis_sp2d | uppercase}}</td>
                        <td>{{ jen.nama_jenis_sp2d }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                title="Lihat Detail Jenis SP2D"
                                @click="showDetailJenisModal(jen)">
                                <i class="fas fa-eye mr-2"></i> Detail
                            </a>
                            
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                title="Edit Data Jenis SP2D"
                                @click="showEditingModal(jen)">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            
                            <!-- <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                                title="Hapus Data Jenis SP2D"
                                @click="deleteJenis(jen.id_jenis_sp2d)">
                                <i class="fas fa-trash"></i>
                            </a> -->
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-left" v-if="searching">
                    <button class="btn btn-success btn-sm" @click="loadJenis()">
                        <i class="fas fa-list-alt mr-2"></i> Semua Jenis SP2D
                    </button>
                </div>
                <div class="float-right">
                    <pagination :data="jenis" @pagination-change-page="getResults" :limit="1"></pagination>
                </div>
            </div>
            </div>
        </div>
        </div>
        <modal-jenis></modal-jenis>
        <detail-jenis></detail-jenis>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                jenis: {},
                counter: 0,
                searching: false,
                jenKeyword: null
            }
        },

        created() {
            Signal.$on('/jenis-surat-search', (keywords) => {
                this.jenKeyword = keywords
                this.searchJenis(keywords)
            }),

            this.loadJenis()
            Signal.$on('load_jenis', () => {
                this.loadJenis();
            })
        },

        computed: {
            isJenisEmpty() {
                if (typeof this.jenis.data == 'undefined' && this.jenis!=null) {
                    return false
                }else if (typeof this.jenis.data != 'undefined' && this.jenis.data.length==0) {
                    return true
                }
            }
        },

        components: {
            "modal-jenis": require('./children/JenisSuratModal.vue'),
            "detail-jenis": require('./children/DetailJenisSuratModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_jenis_modal')
            },

            showEditingModal(jen) {
                Signal.$emit('show_editing_jenis_modal', jen)
            },

            showDetailJenisModal(jen) {
                Signal.$emit('show_detail_jenis_modal', jen)
            },

            loadJenis() {
                if (this.isMaster()) {
                    this.readData('api/jenis')
                    .then((jenis) => {
                        this.jenis = jenis
                        this.counter = jenis.from
                        this.searching = false
                        this.jenKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            // deleteJenis(id) {
            //     if (this.isMaster()) {
            //         this.deleteData('api/jenis/'+id, 'jenis')
            //     }
            // },

            getResults(page = 1) {
                if (this.isMaster()) {
                    if (this.searching==true) {
                        axios.get('api/search-jenis?keywords='+this.jenKeyword+'&page='+page)
                        .then((response) => {
                            this.jenis = response.data.data
                            this.counter = response.data.data.from
                        })
                    }else{
                        axios.get('api/jenis?page='+page)
                        .then((response) => {
                            this.jenis = response.data.data
                            this.counter = response.data.data.from
                        })
                    }
                }
            },

            searchJenis(keywords) {
                if (this.isMaster()) {
                    this.searchData('api/search-jenis?keywords='+keywords)
                    .then((jenis) => {
                        this.jenis = jenis
                        this.searching = true
                    })
                }
            }
        }
    }
</script>