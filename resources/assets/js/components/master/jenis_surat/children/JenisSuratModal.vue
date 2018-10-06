<template>
    <div class="modal fade" id="jenisModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data Jenis SP2D</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data Jenis SP2D</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateJenis() : createJenis()" 
                    @change="clearError"
                >
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodejenis">Kode Jenis</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': jenis.errors.has('kode_jenis_sp2d') }" 
                            id="kodejenis" v-model="jenis.kode_jenis_sp2d" placeholder="UP/GU/TU/LS"
                        >
                        <has-error :form="jenis" field="kode_jenis_sp2d"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="namajenis">Nama Jenis SP2D</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': jenis.errors.has('nama_jenis_sp2d') }" 
                            id="namajenis" v-model="jenis.nama_jenis_sp2d" placeholder="Jenis"
                        >
                        <has-error :form="jenis" field="nama_jenis_sp2d"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="ketjenis">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="..." 
                            :class="{ 'is-invalid': jenis.errors.has('keterangan') }"
                            id="ketjenis" v-model="jenis.keterangan"></textarea>
                        <has-error :form="jenis" field="keterangan"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                                id="statusjenis" v-model="jenis.status">
                        <label class="form-check-label" for="statusjenis">Status Aktif</label>
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
                editing: true,
                jenis: new Form({
                    id_jenis_sp2d: '',
                    kode_jenis_sp2d: '',
                    nama_jenis_sp2d: '',
                    keterangan: '',
                    status: true
                })
            }
        },
        
        created() {
            Signal.$on('show_creating_jenis_modal', () => {
                this.showModal(this.jenis, 'jenis', 'create')
            }),
            Signal.$on('show_editing_jenis_modal', (jen) => {
                this.jenis.status = jen.status
                this.showModal(this.jenis, 'jenis', 'edit', jen)
            })
        },

        methods: {
            clearError() {
                this.jenis.clear()
            },
            createJenis() {
                this.createData(this.jenis, 'api/jenis', 'jenis')
            },
            updateJenis() {
                this.updateData(this.jenis, 'api/jenis/'+this.jenis.id_jenis_sp2d, 'jenis')
            }
        }
    }
</script>