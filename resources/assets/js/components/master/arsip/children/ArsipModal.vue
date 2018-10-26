<template>
    <!-- Modal -->
    <div class="modal fade" id="arsipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Arsipkan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>Nomor Surat : {{ arsip.nomor_surat }}</h5>
            <form @submit.prevent="editing ? updateArsip() : createArsip()"
                    @change="clearError">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gedung</label>
                                    <select class="form-control" @change="selectRuangan" v-model="lokasi.gedung">
                                        <option disabled value=""> --- Pilih Gedung --- </option>
                                        <option v-for="ged in gedung"
                                            :key="ged.id_gedung"
                                            :value="ged.id_gedung">
                                            {{ ged.nama_gedung }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <select class="form-control" @change="selectRak" v-model="lokasi.ruangan"
                                    :disabled="this.lokasi.gedung == '' ? true : false">
                                        <option disabled value=""> --- Pilih Ruangan --- </option>
                                        <option v-for="rua in ruangan"
                                        :key="rua.id_ruangan"
                                        :value="rua.id_ruangan">
                                        {{ rua.kode_ruangan }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Rak</label>
                                    <select class="form-control" @change="selectBox" v-model="lokasi.rak"
                                    :disabled="this.lokasi.ruangan == '' ? true : false">
                                        <option disabled value=""> --- Pilih Rak --- </option>
                                        <option v-for="r in rak"
                                        :key="r.id_rak"
                                        :value="r.id_rak">
                                        {{ r.kode_rak }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Box</label>
                                    <select class="form-control" v-model="arsip.id_box"
                                        :class="{ 'is-invalid': arsip.errors.has('id_box') }"
                                        :disabled="this.lokasi.rak=='' ? true : false">
                                        <option disabled value=""> --- Pilih Box --- </option>
                                        <option v-for="b in box"
                                        :key="b.id_box"
                                        :value="b.id_box">
                                        {{ b.kode_box }}
                                        </option>
                                    </select>
                                    <has-error :form="arsip" field="id_box"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgldiarsipkan">Tanggal Diarsipkan</label>
                            <datepicker :bootstrapStyling="true"
                                        :language="id"
                                        :format="customFormatter"
                                        calendar-button calendar-button-icon="fas fa-calendar-alt"
                                        v-model="arsip.tgl_diarsipkan"
                                        :disabledDates="disabledDates"
                                        id="tgldiarsipkan">
                            </datepicker>
                        </div>
                        <div class="form-group">
                            <label for="ketarsip">Keterangan</label>
                            <textarea class="form-control" rows="2"
                                v-model="arsip.keterangan" placeholder="..." 
                                :class="{ 'is-invalid': arsip.errors.has('keterangan') }"
                                id="ketarsip">
                            </textarea>
                            <has-error :form="arsip" field="keterangan"></has-error>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                    id="statusarsip" v-model="arsip.status">
                            <label class="form-check-label" for="statusarsip">Status Aktif</label>
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
                disabledDates: {
                    to: ''
                },
                id: id,
                editing: true,
                gedung: {},
                ruangan: {},
                rak: {},
                box: {},
                surat: {},
                lokasi: {
                    gedung: '',
                    ruangan: '',
                    rak: ''
                },
                dis_date_ars_composer: new Form({
                    sel_day: '',
                    sel_month: '',
                    sel_year: ''
                }),
                arsip: new Form({
                    id_arsip: '',
                    id_sp2d: '',
                    nomor_surat: '',
                    id_box: '',
                    tgl_diarsipkan: '',
                    keterangan: '',
                    status: true
                })
            }
        },
    
        created() {
            Signal.$on('show_creating_arsip_modal', (sur) => {
                this.lokasi.gedung = ''
                this.lokasi.ruangan = ''
                this.lokasi.rak = ''
                this.showModal(this.arsip, 'arsip', 'create')
                this.surat = sur
                this.arsip.id_sp2d = sur.id_sp2d
                this.arsip.nomor_surat = sur.nomor_surat
                this.splitDisabledDate(sur.tgl_terbit)
            }),

            Signal.$on('show_editing_arsip_modal', (ars) => {
                this.arsip.status = ars.status
                this.arsip.keterangan = ars.keterangan
                this.lokasi.gedung = ars.box.rak.ruangan.gedung.id_gedung
                this.selectRuangan()
                this.lokasi.ruangan = ars.box.rak.ruangan.id_ruangan
                this.selectRak()
                this.lokasi.rak = ars.box.rak.id_rak
                this.selectBox()
                this.lokasi.box = ars.box.id_box
                this.showModal(this.arsip, 'arsip', 'edit', ars)
                this.arsip.nomor_surat = ars.surat.nomor_surat
            })

            if (this.isMasterOrAdmin()) {
                this.getGedung()
                .then((gedung) => {
                    this.gedung = gedung
                })  
            }
        },

        methods: {
            clearError() {
                this.arsip.clear()
            },

            customFormatter(date) {
                return moment(date).locale('id').format('Do MMMM YYYY')
            },

            selectRuangan() {
                if (this.isMasterOrAdmin()) {
                    this.getRuangan(this.lokasi.gedung)
                    .then((ruangan) => {
                        this.ruangan = ruangan
                    })
                }
            },

            selectRak() {
                if (this.isMasterOrAdmin()) {
                    this.getRak(this.lokasi.ruangan)
                    .then((rak) => {
                        this.rak = rak
                    })
                }
            },

            selectBox() {
                if (this.isMasterOrAdmin()) {
                    this.getBox(this.lokasi.rak)
                    .then((box) => {
                        this.box = box
                    })
                }
            },

            createArsip() {
                if(this.datePickerValidation()==true) {
                    if (this.isMasterOrAdmin()) {
                        this.createData(this.arsip, 'api/arsip', 'arsip')
                    }
                }
            },

            updateArsip() {
                if(this.datePickerValidation()==true) {
                    if (this.isMasterOrAdmin()) {
                        this.updateData(this.arsip, 'api/arsip/'+this.arsip.id_arsip, 'arsip')
                    }
                }
            },

            splitDisabledDate(tglTerbitSurat) {
                var disDate = tglTerbitSurat.split('-')
                this.disabledDates.to = new Date(disDate[0], disDate[1]-1, disDate[2])
            },

            datePickerValidation() {
                if(this.arsip.tgl_diarsipkan=='') {
                    swal({
                        text: 'Tanggal diarsipkan harus diisi',
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