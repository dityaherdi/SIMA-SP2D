<template>
    <!-- Modal -->
    <div class="modal fade" id="skpdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data SKPD</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateSkpd() : createSkpd()"
                    @change="clearError"
                >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 ml-auto">
                            <div class="form-group">
                                <label for="kodeskpd">Kode SKPD</label>
                                <input type="text" class="form-control" 
                                    :class="{ 'is-invalid': skpd.errors.has('kode_skpd') }" 
                                    id="kodeskpd" placeholder="0.00.00." v-model="skpd.kode_skpd"
                                   >
                                <has-error :form="skpd" field="kode_skpd"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="namaskpd">Nama SKPD</label>
                                <textarea class="form-control" rows="3" placeholder="SKPD" 
                                    :class="{ 'is-invalid': skpd.errors.has('nama_skpd') }"
                                    id="namaskpd" v-model="skpd.nama_skpd"></textarea>
                                <has-error :form="skpd" field="nama_skpd"></has-error>
                            </div>
                        </div>
                        <div class="col-sm-6 ml-auto">
                            <div class="form-group">
                                <label for="aliasskpd">Nama Alias SKPD</label>
                                <input type="text" class="form-control" 
                                    :class="{ 'is-invalid': skpd.errors.has('alias_skpd') }" 
                                    id="aliasskpd" placeholder="cth: Disbud, Dishub, dll..." v-model="skpd.alias_skpd"
                                   >
                                <has-error :form="skpd" field="alias_skpd"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="ketskpd">Keterangan</label>
                                <textarea class="form-control" rows="3" placeholder="..." 
                                    :class="{ 'is-invalid': skpd.errors.has('keterangan') }"
                                    id="ketskpd" v-model="skpd.keterangan"></textarea>
                                <has-error :form="skpd" field="keterangan"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ml-auto">
                        <div class="form-group">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                    id="statusskpd" v-model="skpd.status">
                            <label class="form-check-label" for="statusskpd">Status Aktif</label>
                            </div>
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
                skpd: new Form({
                    id_skpd:'',
                    kode_skpd: '',
                    nama_skpd: '',
                    alias_skpd: '',
                    keterangan: '',
                    status: true
                })
            }
        },
        
        created() {
            Signal.$on('show_creating_skpd_modal', () => {
                this.editing = false
                this.skpd.reset()
                this.skpd.clear()
                $('#skpdModal').modal('show')
            }),
            Signal.$on('show_editing_skpd_modal', (skpd) => {
                this.editing = true
                this.skpd.reset()
                this.skpd.clear()
                $('#skpdModal').modal('show')
                this.skpd.fill(skpd)
                this.skpd.status = skpd.status
            })
        },

        methods: {
            createSkpd() {
                this.createData(this.skpd, 'api/skpd', 'skpd')
            },
            
            updateSkpd() {
                this.updateData(this.skpd, 'api/skpd/'+this.skpd.id_skpd, 'skpd')
            },

            clearError() {
                this.skpd.clear()
            }
        }
    }
</script>