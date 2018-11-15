<template>
    <div class="modal fade" id="boxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data Box</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data Box</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateBox() : createBox()"
                    @change="clearError">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 ml-auto">
                            <div class="form-group">
                            <label>Gedung Arsip</label>
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
                        <div class="col-md-4 ml-auto">
                            <div class="form-group">
                            <label>Ruangan</label>
                            <span id="ruaEmptyForBox" class="red"></span>
                                <select class="form-control" @change="selectRak" v-model="lokasi.ruangan"
                                    :disabled="this.lokasi.gedung=='' ? true : false">
                                    <option disabled value=""> --- Pilih Ruangan --- </option>
                                    <option v-for="rua in ruangan"
                                        :key="rua.id_ruangan"
                                        :value="rua.id_ruangan">
                                        {{ rua.kode_ruangan }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ml-auto">
                            <div class="form-group">
                            <label>Rak Arsip</label>
                            <span id="rakEmptyForBox" class="red"></span>
                                <select class="form-control" v-model="box.id_rak"
                                    :class="{ 'is-invalid': box.errors.has('id_rak') }"
                                    :disabled="this.lokasi.ruangan=='' ? true : false">
                                    <option disabled value=""> --- Pilih Rak --- </option>
                                    <option v-for="r in rak"
                                        :key="r.id_rak"
                                        :value="r.id_rak">
                                        {{ r.kode_rak }}
                                    </option>
                                </select>
                                <has-error :form="box" field="id_rak"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ml-auto">
                            <div class="form-group">
                                <label for="kodebox">Kode Box</label>
                                <input type="text" class="form-control" 
                                    :class="{ 'is-invalid': box.errors.has('kode_box') }" 
                                    id="kodebox" v-model="box.kode_box"
                                >
                                <has-error :form="box" field="kode_box"></has-error>
                            </div>
                        </div>
                        <div class="col-md-6 ml-auto">
                            <div class="form-group">
                                <label for="kapasitasbox">Kapasitas Box</label>
                                <input type="number" class="form-control" 
                                    :class="{ 'is-invalid': box.errors.has('kapasitas') }" 
                                    id="kapasitasbox" v-model="box.kapasitas"
                                    min="0" oninput="validity.valid||(value='');"
                                >
                                <has-error :form="box" field="kapasitas"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ketbox">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="..." 
                            :class="{ 'is-invalid': box.errors.has('keterangan') }"
                            id="ketbox" v-model="box.keterangan"></textarea>
                        <has-error :form="box" field="keterangan"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                                id="statusbox" v-model="box.status">
                        <label class="form-check-label" for="statusbox">Status Aktif</label>
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
    export default {
        data() {
            return {
                editing: false,
                lokasi: {
                    gedung: '',
                    ruangan: ''
                },
                gedung: {},
                ruangan: {},
                rak: {},
                box: new Form({
                    id_box: '',
                    id_rak: '',
                    kode_box: '',
                    kapasitas: '',
                    keterangan: '',
                    status: true,
                })
            }
        },

        created() {
            Signal.$on('show_creating_box_modal', () => {
                this.lokasi.gedung = ''
                this.lokasi.ruangan = ''
                this.showModal(this.box, 'box', 'create')
            }),

            Signal.$on('show_editing_box_modal', (b) => {
                this.box.status = b.status
                this.lokasi.gedung = b.rak.ruangan.gedung.id_gedung
                this.selectRuangan()
                this.lokasi.ruangan = b.rak.ruangan.id_ruangan
                this.selectRak()
                this.box.id_rak = b.id_rak
                this.showModal(this.box, 'box', 'edit', b)
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
                this.box.clear()
            },

            selectRuangan() {
                if (this.isMasterOrAdmin()) {
                    this.getRuangan(this.lokasi.gedung)
                    .then((ruangan) => {
                        if (ruangan.length==0) {
                            $('#ruaEmptyForBox').text(' : Tidak ada ruangan')
                            this.ruangan = {}
                        } else {
                            $('#ruaEmptyForBox').text('')
                            this.ruangan = ruangan
                        }
                    })
                }
            },

            selectRak() {
                if (this.isMasterOrAdmin()) {
                    this.getRak(this.lokasi.ruangan)
                    .then((rak) => {
                        if (rak.length==0) {
                            $('#rakEmptyForBox').text(' : Tidak ada rak')
                            this.rak = {}
                        } else {
                            $('#rakEmptyForBox').text('')
                            this.rak = rak
                        }
                    })
                }
            },

            createBox() {
                if (this.isMasterOrAdmin()) {
                    this.createData(this.box, 'api/box', 'box')
                }
            },

            updateBox() {
                if (this.isMasterOrAdmin()) {
                    this.updateData(this.box, 'api/box/'+this.box.id_box, 'box')
                }
            }
        }
    }
</script>