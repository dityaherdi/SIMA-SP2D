<template>
    <div>
        <button type="button" class="btn btn-primary" @click="newSkpdModal()">
            Tambah Data SKPD
        </button>
        <ul class="list-group mt-3">
            <li class="list-group-item list-group-item-action" v-for="ars in arsip" :key="ars.id_arsip">
                {{ ars.surat.nomor_surat }}
                <button class="btn btn-primary btn-sm float-right ml-2">
                    <i class="fas fa-eye"></i> Detail
                </button>
                <button class="btn btn-success btn-sm float-right ml-2" @click="showEditingModal(ars)">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </li>
        </ul>
        <modal-arsip></modal-arsip>
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
        },

        mounted() {
            if (this.loadable==true) {
                this.loadMoreArsip()
            }
        },

        components: {
          "modal-arsip": require('./children/ArsipModal.vue')
        },
        
        methods: {
            newSkpdModal() {
                this.$emit('new_skpd')
            },

            showEditingModal(ars) {
                Signal.$emit('show_editing_arsip_modal', ars)
            },

            loadArsip() {
                this.readData('api/arsip')
                .then((arsip) => {
                    this.arsip = arsip.data
                    this.next = arsip.next_page_url
                })
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