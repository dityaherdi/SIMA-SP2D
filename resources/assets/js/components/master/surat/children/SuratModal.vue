<template>
    <!-- Modal -->
    <div class="modal fade" id="suratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data SP2D</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data SP2D</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateSurat() : createSurat()"
                    @change="clearError">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>SKPD</label>
                                <select class="form-control" v-model="surat_req.skpd" @change="selectSkpd($event)"
                                    :class="{ 'is-invalid' :surat.errors.has('id_skpd') }">
                                    <option disabled value=""> --- Pilih SKPD --- </option>
                                    <option v-for="s in skpd"
                                            :key="s.id_skpd"
                                            :value="s.id_skpd+'-'+s.kode_skpd">
                                    {{ s.nama_skpd }}
                                    </option>
                                </select>
                                <has-error :form="surat" field="id_skpd"></has-error>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Jenis SP2D</label>
                                <select class="form-control" v-model="surat_req.jenis" @change="selectJenis($event)"
                                    :class="{ 'is-invalid' :surat.errors.has('id_jenis_sp2d') }">
                                    <option disabled value=""> --- Pilih Jenis SP2D --- </option>
                                    <option v-for="jen in jenis"
                                            :key="jen.id_jenis_sp2d"
                                            :value="jen.id_jenis_sp2d+'-'+jen.kode_jenis_sp2d">
                                    {{ jen.kode_jenis_sp2d }} - {{ jen.nama_jenis_sp2d }}
                                    </option>
                                </select>
                                <has-error :form="surat" field="id_jenis_sp2d"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tglterbit">Tanggal Surat Diterbitkan</label>
                                <datepicker :bootstrapStyling="true"
                                            :language="id"
                                            :format="customFormatter"
                                            calendar-button calendar-button-icon="fas fa-calendar-alt"
                                            v-model="surat.tgl_terbit"
                                            id="tglterbit">
                                </datepicker>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="nomorsurat">Nomor Surat</label>
                            <div class="form-inline form-group">
                                <input type="text" class="form-control form-control-sm" style="max-width:20%"
                                    :class="{ 'is-invalid': surat.errors.has('nomor_surat') }" 
                                    id="nomorsurat" placeholder="Nomor" v-model="no_srt_composer.sel_nomor"
                                >&nbsp;/&nbsp;
                                <input type="text" class="form-control form-control-sm" style="max-width:16%"
                                   placeholder="SP2D" value="SP2D" disabled id="sp2dsurat"
                                >&nbsp;/&nbsp;
                                <input type="text" class="form-control form-control-sm" style="max-width:11%"
                                    :value="no_srt_composer.sel_kode_jenis" disabled id="kodejenissurat"
                                >&nbsp;/&nbsp;
                                <input type="text" class="form-control form-control-sm" style="max-width:21%"
                                    placeholder="SKPD" :value="no_srt_composer.sel_kode_skpd | cleanKodeSkpd" disabled
                                    id="kodeskpdsurat"
                                >&nbsp;/&nbsp;
                                <input type="text" class="form-control form-control-sm" style="max-width:18%"
                                    :class="{ 'is-invalid': surat.errors.has('tgl_terbit') }"
                                    placeholder="Tahun" id="tahunsurat" v-model="no_srt_composer.sel_tahun"
                                >
                                    <input type="hidden" :class="{ 'is-invalid': surat.errors.has('nomor_surat') }">
                                    <has-error :form="surat" field="nomor_surat"></has-error>
                                    <input type="hidden" :class="{ 'is-invalid': surat.errors.has('tgl_terbit') }">
                                    <has-error :form="surat" field="tgl_terbit"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="uraiansurat">Uraian Keperluan</label>
                                <textarea class="form-control" rows="3" placeholder="..." 
                                    :class="{ 'is-invalid': surat.errors.has('uraian') }"
                                    id="uraiansurat" v-model="surat.uraian"></textarea>
                                <has-error :form="surat" field="uraian"></has-error>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="ketsurat">Keterangan</label>
                                <textarea class="form-control" rows="3" placeholder="..." 
                                    :class="{ 'is-invalid': surat.errors.has('keterangan') }"
                                    id="ketsurat" v-model="surat.keterangan"></textarea>
                                <has-error :form="surat" field="keterangan"></has-error>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                        id="statussurat" v-model="surat.status">
                                <label class="form-check-label" for="statussurat">Status Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-ban mr-2"></i>Batal</button>
                        <button type="submit" class="btn btn-primary" v-if="!editing">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                        <button type="submit" class="btn btn-secondary" v-else>
                            <i class="fas fa-check-circle mr-2"></i>Perbarui
                        </button>
                    </div>
                </div>
                
              </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { id } from 'vuejs-datepicker/dist/locale'
    
    export default {
        data() {
            return {
                id: id,
                editing: false,
                skpd: {},
                jenis: {},
                surat_req: {
                    skpd: '',
                    jenis: ''
                },
                no_srt_composer: new Form({
                    sel_nomor: '',
                    sel_kode_skpd: '',
                    sel_kode_jenis: '',
                    sel_tahun: ''
                }),
                surat: new Form({
                    id_sp2d: '',
                    id_skpd: '',
                    id_jenis_sp2d: '',
                    nomor_surat: '',
                    tgl_terbit: '',
                    uraian: '',
                    keterangan: '',
                    status: true
                })
            }
        },

        created() {
            Signal.$on('show_creating_surat_modal', () => {
                this.surat_req.skpd = ''
                this.surat_req.jenis = ''
                this.no_srt_composer.reset()
                this.showModal(this.surat, 'surat', 'create')
            })

            Signal.$on('show_editing_surat_modal', (sur) => {
                this.surat_req.skpd = sur.id_skpd+'-'+sur.skpd.kode_skpd
                this.surat_req.jenis = sur.id_jenis_sp2d+'-'+sur.jenis.kode_jenis_sp2d
                this.surat.status = sur.status
                this.splitNomorSurat(sur.nomor_surat)
                this.showModal(this.surat, 'surat', 'edit', sur)
            })

            this.getSkpd()
            .then((skpd) => {
                this.skpd = skpd
            })

            this.getJenis()
            .then((jenis) => {
                this.jenis=jenis
            })

        },

        methods: {
            combineNomorSurat() {
                var no_srt = $("#nomorsurat, #sp2dsurat, #kodejenissurat, #kodeskpdsurat, #tahunsurat")
                    .map(function(){
                        return this.value
                    }).get().join("/")
                this.surat.nomor_surat = no_srt
            },

            splitNomorSurat(nmr) {
                var no_srt = nmr.split('/')
                this.no_srt_composer.sel_nomor = no_srt[0]
                this.no_srt_composer.sel_kode_skpd = no_srt[3]
                this.no_srt_composer.sel_kode_jenis = no_srt[2]
                this.no_srt_composer.sel_tahun = no_srt[4]
            },

            customFormatter(date) {
                this.no_srt_composer.sel_tahun = moment(date).format('YYYY')
                return moment(date).locale('id').format('Do MMMM YYYY')
            },

            selectSkpd(event) {
                let selectedSkpd = event.target.value.split('-', 2)
                this.surat.id_skpd = selectedSkpd[0]
                this.no_srt_composer.sel_kode_skpd = selectedSkpd[1]
            },

            selectJenis(event) {
                let selectedJenis = event.target.value.split('-', 2)
                this.surat.id_jenis_sp2d = selectedJenis[0]
                this.no_srt_composer.sel_kode_jenis = selectedJenis[1]
            },

            clearError() {
                this.surat.clear()
            },

            createSurat() {
                if(this.datePickerValidation()==true) {
                    this.combineNomorSurat()
                    this.createData(this.surat, 'api/surat', 'surat')
                }
            },

            updateSurat() {
                if(this.datePickerValidation()==true) {
                    this.combineNomorSurat()
                    this.updateData(this.surat, 'api/surat/'+this.surat.id_sp2d, 'surat')
                }
            },

            datePickerValidation() {
                if(this.surat.tgl_terbit=='') {
                    swal({
                        text: 'Tanggal surat diterbitkan harus diisi',
                        type: 'warning'
                    })
                    return false
                }else {
                    return true
                }
            }

        }
    }
</script>