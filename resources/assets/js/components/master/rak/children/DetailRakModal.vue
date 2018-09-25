<template>
    <!-- Modal -->
    <div class="modal fade" id="detailRakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Rak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="text-justify">
                <strong> Detail Letak Rak : </strong> 
                Gedung-{{ rak.nama_gedung }}, Ruangan-{{rak.kode_ruangan}}, Rak-{{ rak.kode_rak }}
            </p><br>
            <p class="text-justify"><strong>Keterangan : </strong> {{ rak.keterangan }} </p><br>
            <p class="text-justify"><strong>Status : </strong> {{ rak.status }} </p><br>
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
            })
        }
    }
</script>

