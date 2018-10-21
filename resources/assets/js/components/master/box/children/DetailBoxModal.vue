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
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link active show" href="#tab_detail_box" data-toggle="tab">Detail</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_label_box" data-toggle="tab">Label</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="tab_detail_rak">
                    <div class="row">
                        <div class="col-md-6">
                            <img :src="'./img/qr/box/'+box.qr_box" alt="QRCode Box">
                        </div>
                        <div class="col-md-6">
                            <p class="text-justify">
                                <strong> Detail Letak Rak : </strong> 
                                Gedung-{{ box.nama_gedung }}, Ruangan-{{box.kode_ruangan}}, Rak-{{ box.kode_box }}
                            </p>
                            <p class="text-justify"><strong>Jumlah Arsip : </strong> {{ box.kapasitas }} </p>
                            <p class="text-justify"><strong>Keterangan : </strong> {{ box.keterangan }} </p>
                            <p class="text-justify"><strong>Status : </strong> {{ box.status }} </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_label_box">
                    <div class="container border border-dark" id="boxLabel">
                        <div class="widget-user-header bg-info-active">
                            <div class="text-center mt-2">
                                <img src="/img/logo.png" alt="Logo BPKAD" style="width:100px" >
                                <div class="mt-2">
                                    <h5>PEMERINTAH PROVINSI BALI</h5>
                                    <strong class="mb-2">BADAN PENGELOLA KEUANGAN DAN ASET DAERAH</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border border-dark">
                            <div class="row">
                            <div class="col-sm-6 border-right border-dark">
                                <div class="description-block">
                                    <img :src="'./img/qr/box/'+box.qr_box" alt="QRCode Box" style="width:150px">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description-block">
                                <span class="description-text">Kode Box</span>
                                <h5 class="description-header">{{ box.kode_box }}</h5>
                                </div>
                                <div class="border border-dark text-center">
                                    <strong>BOX ARSIP</strong>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="container border border-dark mt-2 mb-2">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center mt-3">
                            <button type="button" class="btn btn-secondary" @click="printBoxLabel">
                                <i class="fas fa-print mr-2"></i>Cetak Label Box
                            </button>
                        </div>
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
        },

        methods: {
            printBoxLabel() {
                html2canvas(document.getElementById('boxLabel'))
                .then((canvas) => {
                    console.log('hello')
                    let ss = canvas.toDataURL('image/png')
                    let boxLabel = new jsPDF('l', 'pt', 'a5')
                    boxLabel.addImage(ss, 'PNG', 10, 10)
                    boxLabel.save('box_label_'+this.box.kode_box+'.pdf')
                })
            }
        }
    }
</script>

