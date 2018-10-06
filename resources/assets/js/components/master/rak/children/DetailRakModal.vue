<template>
    <!-- Modal -->
    <div class="modal fade" id="detailRakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Rak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <img :src="'./img/qr/rak/'+rak.qr_rak" alt="QRCode Rak">
                </div>
                <div class="col-md-6">
                     <p class="text-justify">
                        <strong> Detail Letak Rak : </strong> 
                        Gedung-{{ rak.nama_gedung }}, Ruangan-{{rak.kode_ruangan}}, Rak-{{ rak.kode_rak }}
                    </p>
                    <p class="text-justify"><strong>Keterangan : </strong> {{ rak.keterangan }} </p>
                    <p class="text-justify"><strong>Status : </strong> {{ rak.status }} </p>
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
                rak: {
                    nama_gedung: '',
                    kode_ruangan: '',
                    kode_rak: '',
                    qr_rak: '',
                    keterangan: '',
                    status: ''
                }
            }
        },
    
        created() {
            Signal.$on('show_detail_rak_modal', (r) => {
                this.showModal(null, 'Rak', 'detail', null)
                this.rak.nama_gedung = r.ruangan.gedung.nama_gedung
                this.rak.kode_ruangan = r.ruangan.kode_ruangan
                this.rak.kode_rak = r.kode_rak
                if (r.keterangan==null) {
                    this.rak.keterangan = '-'
                }else{
                    this.rak.keterangan = r.keterangan
                }
                if (r.status===1) {
                    this.rak.status = 'Aktif'
                }else if (r.status===0) {
                    this.rak.status = 'Non-Aktif'
                }
                this.rak.qr_rak = r.qr_rak
            })
        }
    }
</script>

