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
            <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#tab_detail_rak" data-toggle="tab">
                            <i class="fas fa-info mr-2"></i> Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab_label_rak" data-toggle="tab">
                            <i class="fas fa-tag mr-2"></i> Label
                        </a>
                    </li>
                </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="tab_detail_rak">
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
                <div class="tab-pane" id="tab_label_rak">
                    <div class="container border border-dark" id="rakLabel">
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
                                    <img :src="'./img/qr/rak/'+rak.qr_rak" alt="QRCode Rak" style="width:150px">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="description-block">
                                <span class="description-text">Kode Rak</span>
                                <h5 class="description-header">{{ rak.kode_rak }}</h5>
                                </div>
                                <div class="border border-dark text-center">
                                    <strong>RAK ARSIP</strong>
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
                            <button type="button" class="btn btn-secondary" @click="printRakLabel">
                                <i class="fas fa-print mr-2"></i>Cetak Label Rak
                            </button>
                        </div>
                    </div>
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
        },

        methods: {
            printRakLabel() {
                html2canvas(document.getElementById('rakLabel'))
                .then((canvas) => {
                    console.log('hello')
                    let ss = canvas.toDataURL('image/png')
                    let rakLabel = new jsPDF('l', 'pt', 'a5')
                    rakLabel.addImage(ss, 'PNG', 10, 10)
                    rakLabel.save('rak_label_'+this.rak.kode_rak+'.pdf')
                })
            }
        }
    }
</script>

