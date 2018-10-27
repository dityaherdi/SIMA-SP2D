<template>
    <!-- Modal -->
    <div class="modal fade" id="detailSuratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail SP2D</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-justify"><strong>SKPD : </strong> {{ surat.skpd }} </p>
                    <p class="text-justify"><strong>Jenis SP2D : </strong> {{ surat.jenis }} </p>
                    <p class="text-justify"><strong>Nomor Surat : </strong> {{ surat.nomor_surat }} </p>
                    <p class="text-justify"><strong>Tanggal Terbit : </strong> {{ surat.tgl_terbit }} </p>
                    <p class="text-justify"><strong>Uraian Penggunaan : </strong> {{ surat.uraian }} </p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ surat.keterangan }} </p>
                    <p class="text-justify"><strong>Status : </strong> {{ surat.status }} </p>
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
                surat: {
                    skpd: '',
                    jenis: '',
                    nomor_surat: '',
                    tgl_terbit: '',
                    uraian:'',
                    keterangan:'',
                    status:''
                }
            }
        },
    
        created() {
            Signal.$on('show_detail_surat_modal', (sur) => {
                this.surat.skpd = sur.skpd.nama_skpd
                this.surat.jenis = sur.jenis.nama_jenis_sp2d
                this.surat.nomor_surat = sur.nomor_surat
                this.surat.tgl_terbit = sur.tgl_terbit
                if (sur.uraian==null) {
                    this.surat.uraian = '-'
                }else{
                    this.surat.uraian = sur.uraian
                }
                if (sur.keterangan==null) {
                    this.surat.keterangan = '-'
                }else{
                    this.surat.keterangan = sur.keterangan
                }
                if (sur.status===1) {
                    this.surat.status = 'Aktif'
                }else if (sur.status===0) {
                    this.surat.status = 'Non-Aktif'
                }
                this.showModal(null, 'Surat', 'detail', null)
            })
        }
    }
</script>

