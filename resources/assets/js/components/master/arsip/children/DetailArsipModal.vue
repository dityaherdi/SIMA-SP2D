<template>
    <!-- Modal -->
    <div class="modal fade" id="detailArsipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Arsip SP2D</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#tab_detail_arsip" data-toggle="tab">
                            <i class="fas fa-info mr-2"></i> Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab_label_arsip" data-toggle="tab">
                            <i class="fas fa-tag mr-2"></i> Label
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab_detail_arsip">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img :src="'./img/qr/arsip/'+arsip.qr_arsip" alt="QRCode Arsip">
                            </div>
                            <div class="col-md-6">
                                <p class="test-justify"><strong>Nomor Surat :</strong> {{ arsip.nomor_surat }} </p>
                                <p class="test-justify"><strong>Tanggal Surat Diterbitkan :</strong> {{ arsip.tgl_terbit }} </p>
                                <p class="test-justify"><strong>Tanggal Diarsipkan :</strong> {{ arsip.tgl_diarsipkan }} </p>
                                <p class="test-justify"><strong>Tanggal Perkiraan Retensi: </strong> {{ arsip.tgl_perkiraan_retensi }} </p>
                                <p class="test-justify"><strong>SKPD : </strong> {{ arsip.nama_skpd }} </p>
                                <p class="test-justify"><strong>Jenis SP2D : </strong> {{ arsip.nama_jenis_sp2d }} </p>
                                <p class="test-justify"><strong>Uraian : </strong> {{ arsip.uraian }} </p>
                                <p class="test-justify"><strong>Box : </strong> {{ arsip.kode_box }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_label_arsip">
                        <div class="container border border-dark" id="arsipLabel">
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
                                        <img :src="'./img/qr/arsip/'+arsip.qr_arsip" alt="QRCode Box" style="width:150px">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="description-block">
                                    <span class="description-text">Nomor Surat</span>
                                    <h5 class="description-header">{{ arsip.nomor_surat }}</h5>
                                    </div>
                                    <div class="border border-dark text-center">
                                        <strong>ARSIP SP2D</strong>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="container border border-dark mt-2 mb-2">
                                <b>Terbit :</b> {{ arsip.tgl_terbit | tanggalLokal }}
                                |
                                <b>Diarsipkan :</b> {{ arsip.tgl_diarsipkan | tanggalLokal }}
                                |
                                <b>Perkiraan Retensi :</b> {{ arsip.tgl_perkiraan_retensi | tanggalLokal }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mt-3">
                                <button type="button" class="btn btn-secondary" @click="printArsipLabel">
                                    <i class="fas fa-print mr-2"></i>Cetak Label Arsip
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
                arsip : {
                    id_arsip: '',
                    nomor_surat: '',
                    tgl_terbit: '',
                    tgl_diarsipkan: '',
                    tgl_perkiraan_retensi: '',
                    qr_arsip: '',
                    nama_skpd: '',
                    nama_jenis_sp2d: '',
                    uraian: '',
                    kode_box: ''
                }
            }
        },

        created() {
            Signal.$on('show_detail_arsip_modal', (ars) => {
                this.showModal(null, 'Arsip', 'detail', null)
                this.arsip.id_arsip = ars.id_arsip
                this.arsip.nomor_surat = ars.surat.nomor_surat
                this.arsip.tgl_terbit = ars.surat.tgl_terbit
                this.arsip.tgl_diarsipkan = ars.tgl_diarsipkan
                this.arsip.tgl_perkiraan_retensi = ars.tgl_perkiraan_retensi
                this.arsip.qr_arsip = ars.qr_arsip
                this.arsip.nama_skpd = ars.surat.skpd.nama_skpd
                this.arsip.nama_jenis_sp2d = ars.surat.jenis.nama_jenis_sp2d
                if (ars.surat.uraian==null) {
                    this.arsip.uraian = '-'    
                }else{
                    this.arsip.uraian = ars.surat.uraian
                }
                this.arsip.kode_box = ars.box.kode_box
            })
        },

        methods: {
            printArsipLabel() {
                html2canvas(document.getElementById('arsipLabel'))
                .then((canvas) => {
                    let filename = this.arsip.nomor_surat.replace(/\//g, '_')
                    let ss = canvas.toDataURL('image/png')
                    let arsLabel = new jsPDF('l', 'pt', 'a5')
                    arsLabel.addImage(ss, 'PNG', 10, 10)
                    arsLabel.save('arsip_sp2d_label_'+filename+'.pdf')
                })
            }
        }
    }
</script>