<template>
    <div>
        <ul class="list-group mt-3">
            <li class="list-group-item list-group-item-action" v-for="ars in arsip" :key="ars.id_arsip">
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
        <modal-arsip></modal-arsip>
        <detail-arsip></detail-arsip>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                arsip: {},
                next: null,
                loadable: true
            }
        },

        created() {
            this.loadArsip()
            Signal.$on('load_arsip', () => {
                this.loadArsip()
            })
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
        
        methods: {
            showEditingModal(ars) {
                Signal.$emit('show_editing_arsip_modal', ars)
            },

            showDetailModal(ars) {
                Signal.$emit('show_detail_arsip_modal', ars)
            },

            retensi(ars) {
                this.deleteData('api/arsip/'+ars.id_arsip, 'arsip')
            },

            loadArsip() {
                this.readData('api/arsip')
                .then((arsip) => {
                    this.loadable = true
                    this.arsip = arsip.data
                    this.next = arsip.next_page_url
                })
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
    }
</script>