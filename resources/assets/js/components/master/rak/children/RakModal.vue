<template>
    <!-- Modal -->
    <div class="modal fade" id="rakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editing">Tambah Data Rak</h5>
                <h5 class="modal-title" id="exampleModalLongTitle" v-else>Edit Data Rak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateRak() : createRak()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 ml-auto">
                            <div class="form-group">
                            <label>Gedung Arsip</label>
                                <select class="form-control">
                                    <option disabled value=""> --- Pilih Gedung --- </option>
                                    <option v-for="ged in gedung"
                                        :key="ged.id_gedung"
                                        :value="ged.id_gedung">
                                        {{ ged.kode_gedung }}
                                    </option>
                                </select>
                                <has-error :form="rak" field="id_ruangan"></has-error>
                            </div>    
                        </div>
                        <div class="col-sm-6 ml-auto">
                            <div class="form-group">
                            <label>Ruangan Penyimpanan</label>
                                <select class="form-control" v-model="rak.id_ruangan"
                                    :class="{ 'is-invalid': rak.errors.has('id_ruangan') }" disabled>
                                    <option disabled value=""> --- Pilih Ruangan --- </option>
                                    <option v-for="rua in ruangan"
                                        :key="rua.id_ruangan"
                                        :value="rua.id_ruangan">
                                        {{ rua.kode_ruangan }}
                                    </option>
                                </select>
                                <has-error :form="rak" field="id_ruangan"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="koderak">Kode Rak</label>
                        <input type="text" class="form-control" 
                            :class="{ 'is-invalid': rak.errors.has('kode_rak') }" 
                            id="koderak" v-model="rak.kode_rak"
                            @change="clearError">
                        <has-error :form="rak" field="kode_rak"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="ketrak">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="..." 
                            :class="{ 'is-invalid': rak.errors.has('keterangan') }"
                            id="ketrak" v-model="rak.keterangan" @change="clearError"></textarea>
                        <has-error :form="rak" field="keterangan"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                                id="statusrak" v-model="rak.status">
                        <label class="form-check-label" for="statusrak">Status Aktif</label>
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
                ruangan: {},
                rak: new Form({
                    id_rak: '',
                    id_ruangan: '',
                    kode_rak: '',
                    keterangan: '',
                    status: ''
                })
            }
        },

        created() {
            Signal.$on('show_creating_rak_modal', () => {
                this.editing = false;
                $('#rakModal').modal('show')
            }),

            Signal.$on('show_editing_rak_modal', () => {
                this.editing = true;
                $('#rakModal').modal('show')
            })

            this.getRuangan()
        },

        methods: {
            clearError() {
                this.rak.clear()
            },
            getRuangan() {
                axios.get('api/get-ruangan')
                .then((response) => {
                    this.ruangan = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },
            createRak() {
                console.log('creating rak')
            },

            updateRak() {
                console.log('updating rak')
            }
        }
    }
</script>