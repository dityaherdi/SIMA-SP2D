<template>
    <!-- Modal -->
    <div class="modal fade" id="detailSkpdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail SKPD</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-justify"><strong>Kode SKPD : </strong> {{ skpd.kode_skpd }}</p>
                    <p class="text-justify"><strong>Nama SKPD : </strong> {{ skpd.nama_skpd }}</p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ skpd.keterangan }}</p>
                    <p class="text-justify"><strong>Status : </strong> {{ skpd.status }}</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-window-close mr-2"></i> Tutup
            </button>
        </div>
        </div>
    </div>
    </div>    
</template>

<script>
    export default {
        data() {
            return {
                skpd: {
                    kode_skpd: '',
                    nama_skpd: '',
                    keterangan: '',
                    status: ''
                }
            }
        },

        created() {
            Signal.$on('show_detail_skpd_modal', (skpd) => {
                this.skpd.kode_skpd = skpd.kode_skpd
                this.skpd.nama_skpd = skpd.nama_skpd
                if (skpd.keterangan==null) {
                    this.skpd.keterangan = '-'
                }else{
                    this.skpd.keterangan = skpd.keterangan
                }
                if (skpd.status===1) {
                    this.skpd.status = 'Aktif'
                }else if (skpd.status===0) {
                    this.skpd.status = 'Non-Aktif'
                }
                this.showModal(null, 'Skpd', 'detail', null)
            })
        }
    }
</script>

