<template>
    <!-- Modal -->
    <div class="modal fade" id="detailGedungModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Gedung</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-justify"><strong>Kode Gedung : </strong> {{ gedung.kode_gedung }} </p>
                    <p class="text-justify"><strong>Nama Gedung : </strong> {{ gedung.nama_gedung }} </p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ gedung.keterangan }} </p>
                    <p class="text-justify"><strong>Status : </strong> {{ gedung.status }} </p>
                </div>
            </div>
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
                gedung: {
                    kode_gedung: '',
                    nama_gedung: '',
                    keterangan: '',
                    status: '',
                }
            }
        },
        created() {
            Signal.$on('show_detail_gedung_modal', (ged) => {
                this.showModal(null, 'Gedung', 'detail', null)
                this.gedung.kode_gedung = ged.kode_gedung
                this.gedung.nama_gedung = ged.nama_gedung
                if (ged.keterangan==null) {
                    this.gedung.keterangan = '-'
                }else{
                    this.gedung.keterangan = ged.keterangan
                }
                if (ged.status===1) {
                    this.gedung.status = 'Aktif'
                }else if (get.status===0) {
                    this.gedung.status = 'Non-Aktif'
                }
            })
        }
    }
</script>

