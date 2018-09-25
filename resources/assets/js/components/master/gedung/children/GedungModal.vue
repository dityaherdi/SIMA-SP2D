<template>
    <!-- Modal -->
    <div class="modal fade" id="gedungModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data Gedung</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data Gedung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateGedung() : createGedung()"
                        @change="clearError"
                >
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodegedung">Kode Gedung</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': gedung.errors.has('kode_gedung') }" 
                            id="kodegedung" v-model="gedung.kode_gedung" placeholder=""
                        >
                        <has-error :form="gedung" field="kode_gedung"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="namagedung">Nama Gedung</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': gedung.errors.has('nama_gedung') }" 
                            id="namagedung" v-model="gedung.nama_gedung" placeholder=""
                        >
                        <has-error :form="gedung" field="nama_gedung"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="ketgedung">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="..." 
                            :class="{ 'is-invalid': gedung.errors.has('keterangan') }"
                            id="ketgedung" v-model="gedung.keterangan"></textarea>
                        <has-error :form="gedung" field="keterangan"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                                id="statusgedung" v-model="gedung.status">
                        <label class="form-check-label" for="statusgedung">Status Aktif</label>
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
                gedung: new Form({
                    id_gedung: '',
                    kode_gedung: '',
                    nama_gedung: '',
                    keterangan: '',
                    status: true
                })
            }
        },
        created() {
            Signal.$on('show_creating_gedung_modal', () => {
                this.showModal(this.gedung, 'gedung', 'create')
            }),
            Signal.$on('show_editing_gedung_modal', (ged) => {
                this.showModal(this.gedung, 'gedung', 'edit', ged)
                this.gedung.status = ged.status
            })
        },
        methods: {
            createGedung() {
                this.createData(this.gedung, 'api/gedung', 'gedung')
            },
            updateGedung() {
                this.updateData(this.gedung, 'api/gedung/'+this.gedung.id_gedung, 'gedung')
            },
            clearError() {
                this.gedung.clear()
            },

        }
    }
</script>