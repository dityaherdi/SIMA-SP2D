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
                <div class="col-md-4 ml-auto">
                    <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-kode-list" 
                        data-toggle="list" href="#list-kode" role="tab" aria-controls="kode">Kode SKPD</a>
                    <a class="list-group-item list-group-item-action" id="list-nama-list" 
                        data-toggle="list" href="#list-nama" role="tab" aria-controls="nama">Nama SKPD</a>
                    <a class="list-group-item list-group-item-action" id="list-keterangan-list" 
                        data-toggle="list" href="#list-keterangan" role="tab" aria-controls="keterangan">Keterangan</a>
                    <a class="list-group-item list-group-item-action" id="list-status-list" 
                        data-toggle="list" href="#list-status" role="tab" aria-controls="status">Status</a>
                    </div>
                </div>
                <div class="col-md-8 ml-auto">
                    <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade text-justify show active" id="list-kode" role="tabpanel" 
                        aria-labelledby="list-kode-list">{{ skpd.kode_skpd }}</div>
                    <div class="tab-pane fade text-justify" id="list-nama" role="tabpanel" 
                        aria-labelledby="list-nama-list">{{ skpd.nama_skpd }}</div>
                    <div class="tab-pane fade text-justify" id="list-keterangan" role="tabpanel" 
                        aria-labelledby="list-keterangan-list">{{ skpd.keterangan }}</div>
                    <div class="tab-pane fade text-justify" id="list-status" role="tabpanel" 
                        aria-labelledby="list-status-list">{{ skpd.status }}</div>
                    </div>
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
                $('#detailSkpdModal').modal('show')
                this.skpd.kode_skpd = skpd.kode_skpd
                this.skpd.nama_skpd = skpd.nama_skpd
                this.skpd.keterangan = skpd.keterangan
                if (skpd.status===1) {
                    this.skpd.status = 'Aktif'
                }else if (skpd.status===0) {
                    this.skpd.status = 'Non-Aktif'
                }
            })
        }
    }
</script>

