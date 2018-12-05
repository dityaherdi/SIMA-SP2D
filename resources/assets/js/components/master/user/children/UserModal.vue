<template>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" @submit.prevent="editing ? updateUser() : createUser()"
                    @change="clearError">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 ml-auto">
                            <label for="nipuser">NIP</label>
                            <div class="form-inline form-group">
                                <input type="text" class="form-control" style="max-width:32%"
                                    :class="{ 'is-invalid': user.errors.has('nip') }" 
                                    id="nipttl"
                                    v-model="nip_composer.nip_ttl" maxlength="8"
                                >&nbsp;&nbsp;
                                <input type="text" class="form-control" style="max-width:26%"
                                    id="nipcpns"
                                    v-model="nip_composer.nip_cpns" maxlength="6"
                                >&nbsp;&nbsp;
                                <input type="text" class="form-control" style="max-width:15%"
                                    id="nipjk"
                                    v-model="nip_composer.nip_jk" maxlength="1"
                                >&nbsp;&nbsp;
                                <input type="text" class="form-control" style="max-width:20%"
                                    id="nipurut"
                                    v-model="nip_composer.nip_urut" maxlength="3"
                                >
                                <input type="hidden" :class="{ 'is-invalid': user.errors.has('nip') }">
                                <has-error :form="user" field="nip"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="namauser">Nama</label>
                                <input type="text" class="form-control" 
                                    :class="{ 'is-invalid': user.errors.has('nama') }" 
                                    id="namauser" v-model="user.nama"
                                    >
                                <has-error :form="user" field="nama"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="usernameuser">Username</label>
                                <input type="text" class="form-control" 
                                    :class="{ 'is-invalid': user.errors.has('username') }" 
                                    id="usernameuser" v-model="user.username"
                                    >
                                <has-error :form="user" field="username"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="passworduser">Password</label>
                                <input type="password" class="form-control" 
                                    :class="{ 'is-invalid': user.errors.has('password') }" 
                                    id="passworduser" v-model="user.password"
                                    >
                                <has-error :form="user" field="password"></has-error>
                            </div>
                        </div>
                        <div class="col-md-6 ml-auto">
                            <div class="form-group">
                            <label for="usertipe">Tipe User</label>
                                <select class="form-control" v-model="user.tipe" id="usertipe"
                                :class="{ 'is-invalid': user.errors.has('tipe') }">
                                    <option disabled value=""> --- Pilih Tipe --- </option>
                                    <option value="Master"> Master </option>
                                    <option value="Admin"> Admin </option>
                                    <option value="Pimpinan"> Pimpinan </option>
                                </select>
                                <has-error :form="user" field="tipe"></has-error>
                            </div> 
                            <div class="form-group">
                                <label>Foto Profil ( Ukuran &lt; 2MB )</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fotouser"
                                            @change="changeFoto">
                                        <label class="custom-file-label" for="fotouser">{{ fotoName }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ketuser">Keterangan</label>
                                <textarea class="form-control" rows="4" placeholder="..." 
                                    :class="{ 'is-invalid': user.errors.has('keterangan') }"
                                    id="ketuser" v-model="user.keterangan"></textarea>
                                <has-error :form="user" field="keterangan"></has-error>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                        id="statususer" v-model="user.status">
                                <label class="form-check-label" for="statususer">Status Aktif</label>
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
            return{
                editing: true,
                fotoName: '',
                user: new Form({
                    id_user: '',
                    nip: '',
                    nama: '',
                    username: '',
                    password: '',
                    tipe: '',
                    foto: '',
                    keterangan: '',
                    status: true
                }),
                nip_composer : {
                    nip_ttl: '',
                    nip_cpns: '',
                    nip_jk: '',
                    nip_urut: ''
                }
            }
        },

        created() {
            Signal.$on('show_creating_user_modal', () => {
                this.showModal(this.user, 'user', 'create')
            }),

            Signal.$on('show_editing_user_modal', (user) => {
                this.fotoName = user.foto
                this.user.status = user.status
                this.splitNip(user.nip)
                this.showModal(this.user, 'user', 'edit', user)
            })
        },

        methods: {
            clearError() {
                this.user.clear()
            },

            combineNip() {
                let nip = $("#nipttl,#nipcpns,#nipjk,#nipurut").map(function() {
                    return this.value
                }).get().join(' ')
                this.user.nip = nip
            },

            splitNip(nip) {
                let splittedNip = nip.split(' ')
                this.nip_composer.nip_ttl = splittedNip[0]
                this.nip_composer.nip_cpns = splittedNip[1]
                this.nip_composer.nip_jk = splittedNip[2]
                this.nip_composer.nip_urut = splittedNip[3]
            },

            changeFoto(event) {
                let file = event.target.files[0]
                let reader = new FileReader()

                if (file.type=='image/png' || file.type=='image/jpeg') {
                    if (file.size < 2097152) {
                        reader.onload = (event) => {
                            this.user.foto = reader.result
                            this.fotoName = file.name
                        }
        
                        reader.readAsDataURL(file)
                    }else {
                        setTimeout(() => {
                            swal({
                                type: 'error',
                                title: 'Ukuran file terlalu besar',
                                text: 'Gunakan foto dengan ukuran dibawah 2 MB (Mega Bytes)'
                            })
                        }, 1000)
                    }
                }else {
                    setTimeout(() => {
                        swal({
                            type: 'error',
                            title: 'Format foto tidak sesuai',
                            text: 'Gunakan foto dengan format .jpg atau .png'
                        })
                    }, 1000)
                }

            },

            createUser() {
                if (this.isMasterOrAdmin()) {
                    this.combineNip()
                    this.createData(this.user, 'api/user', 'user')
                }
            },

            updateUser() {
                if (this.isMasterOrAdmin()) {
                    this.combineNip()
                    this.updateData(this.user, 'api/user/'+this.user.id_user, 'user')
                }
            }
        }
    }
</script>