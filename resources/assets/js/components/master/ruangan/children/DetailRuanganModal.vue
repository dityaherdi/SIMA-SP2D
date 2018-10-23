<template>
    <!-- Modal -->
    <div class="modal fade" id="detailRuanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Ruangan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-justify"><strong>Gedung : </strong> {{ ruangan.nama_gedung }} </p>
                    <p class="text-justify"><strong>Kode Ruangan : </strong> {{ ruangan.kode_ruangan }} </p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ ruangan.keterangan }} </p>
                    <p class="text-justify"><strong>Status : </strong> {{ ruangan.status }} </p>
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
                ruangan: {
                    nama_gedung: '',
                    kode_ruangan: '',
                    keterangan: '',
                    status: ''
                }
            }
        },
    
        created() {
            Signal.$on('show_detail_ruangan_modal', (rua) => {
                this.showModal(null, 'Ruangan', 'detail', null)
                this.ruangan.nama_gedung = rua.gedung.nama_gedung
                this.ruangan.kode_ruangan = rua.kode_ruangan
                if (rua.keterangan==null) {
                    this.ruangan.keterangan = '-'
                }else{
                    this.ruangan.keterangan = rua.keterangan
                }
                if (rua.status===1) {
                    this.ruangan.status = 'Aktif'
                }else if (rua.status===0) {
                    this.ruangan.status = 'Non-Aktif'
                }
            })
        }
    }
</script>

