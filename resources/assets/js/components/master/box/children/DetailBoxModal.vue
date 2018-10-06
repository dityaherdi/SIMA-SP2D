<template>
    <!-- Modal -->
    <div class="modal fade" id="detailBoxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Box</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <img :src="'./img/qr/box/'+box.qr_box" alt="QRCode Rak">
                </div>
                <div class="col-md-6">
                     <p class="text-justify">
                        <strong> Detail Letak Rak : </strong> 
                        Gedung-{{ box.nama_gedung }}, Ruangan-{{box.kode_ruangan}}, Rak-{{ box.kode_box }}
                    </p>
                    <p class="text-justify"><strong>Kapasitas Sisa : </strong> {{ box.kapasitas }} </p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ box.keterangan }} </p>
                    <p class="text-justify"><strong>Status : </strong> {{ box.status }} </p>
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
                box: {
                    nama_gedung: '',
                    kode_ruangan: '',
                    kode_rak: '',
                    kode_box: '',
                    qr_box: '',
                    kapasitas: '',
                    keterangan: '',
                    status: ''
                }
            }
        },
    
        created() {
            Signal.$on('show_detail_box_modal', (b) => {
                this.showModal(null, 'Box', 'detail', null)
                this.box.nama_gedung = b.rak.ruangan.gedung.nama_gedung
                this.box.kode_ruangan = b.rak.ruangan.kode_ruangan
                this.box.kode_box = b.kode_box
                this.box.kapasitas = b.kapasitas
                if (b.keterangan==null) {
                    this.box.keterangan = '-'
                }else{
                    this.box.keterangan = b.keterangan
                }
                if (b.status===1) {
                    this.box.status = 'Aktif'
                }else if (b.status===0) {
                    this.box.status = 'Non-Aktif'
                }
                this.box.qr_box = b.qr_box
            })
        }
    }
</script>

