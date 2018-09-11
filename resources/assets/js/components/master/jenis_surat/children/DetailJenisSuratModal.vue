<template>
    <!-- Modal -->
    <div class="modal fade" id="detailJenisSuratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Jenis SP2D</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="text-justify"><strong>Kode Jenis SP2D : </strong> {{ jenis.kode_jenis_sp2d | uppercase }}</p><br>
            <p class="text-justify"><strong>Nama Jenis SP2D : </strong> {{ jenis.nama_jenis_sp2d }}</p><br>
            <p class="text-justify"><strong>Keterangan : </strong> {{ jenis.keterangan }}</p><br>
            <p class="text-justify"><strong>Status : </strong> {{ jenis.status }}</p><br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
    </div>    
</template>

<script>
    export default {
        data() {
            return {
                jenis: {
                    kode_jenis_sp2d: '',
                    nama_jenis_sp2d: '',
                    keterangan: '',
                    status: ''
                }
            }
        },

        created() {
            Signal.$on('show_detail_jenis_modal', (jen) => {
                $('#detailJenisSuratModal').modal('show')
                this.jenis.kode_jenis_sp2d = jen.kode_jenis_sp2d
                this.jenis.nama_jenis_sp2d = jen.nama_jenis_sp2d
                if (jen.keterangan==null) {
                    this.jenis.keterangan = '-'
                }else{
                    this.jenis.keterangan = jen.keterangan
                }
                if (jen.status===1) {
                    this.jenis.status = 'Aktif'
                }else if (jen.status===0) {
                    this.jenis.status = 'Non-Aktif'
                }
            })
        }
    }
</script>

