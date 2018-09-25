<template>
    <!-- Modal -->
    <div class="modal fade" id="ruanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data Ruangan</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateRuangan() : createRuangan()"
                    @change="clearError"
                >
                <div class="card-body">
                    <div class="form-group">
                    <label>Gedung Penyimpanan</label>
                        <select class="form-control" v-model="ruangan.id_gedung"
                            :class="{ 'is-invalid': ruangan.errors.has('id_gedung') }">
                            <option disabled value=""> --- Pilih Gedung --- </option>
                            <option v-for="ged in gedung"
                                :key="ged.id_gedung"
                                :value="ged.id_gedung">
                                {{ ged.nama_gedung }}
                            </option>
                        </select>
                        <has-error :form="ruangan" field="id_gedung"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="koderuangan">Kode Ruangan</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': ruangan.errors.has('kode_ruangan') }" 
                            id="koderuangan" v-model="ruangan.kode_ruangan"
                        >
                        <has-error :form="ruangan" field="kode_ruangan"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="ketruangan">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="..." 
                            :class="{ 'is-invalid': ruangan.errors.has('keterangan') }"
                            id="ketruangan" v-model="ruangan.keterangan"></textarea>
                        <has-error :form="ruangan" field="keterangan"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                                id="statusruangan" v-model="ruangan.status">
                        <label class="form-check-label" for="statusruangan">Status Aktif</label>
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
                gedung: {},
                ruangan: new Form({
                    id_ruangan:'',
                    id_gedung: '',
                    kode_ruangan: '',
                    keterangan: '',
                    status: true
                })
            }
        },

        created() {
            Signal.$on('show_creating_ruangan_modal', () => {
                this.showModal(this.ruangan, 'ruangan', 'create')
            }),
            
            Signal.$on('show_editing_ruangan_modal', (rua) => {
                this.showModal(this.ruangan, 'ruangan', 'edit', rua)
                this.status = rua.status
            }),

            this.gedung = this.getGedung()
            .then((gedung) => {
                this.gedung = gedung
            })
        },

        methods: {
            clearError() {
                this.ruangan.clear()
            },

            createRuangan() {
                this.createData(this.ruangan, 'api/ruangan', 'ruangan')
            },

            updateRuangan() {
                this.updateData(this.ruangan, 'api/ruangan/'+this.ruangan.id_ruangan, 'ruangan')
            }
        }
    }
</script>