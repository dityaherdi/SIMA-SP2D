<template>
    <div class="content">
        <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" :src="'./img/profile/'+currentUser.foto" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ currentUser.nama }}</h3>

                <p class="text-muted text-center" style="font-size: 10pt">NIP : {{ currentUser.nip }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Username</b> <a class="float-right">{{ currentUser.username }}</a>
                </li>
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right">{{ currentUser.status | statusUserInProfile }}</a>
                </li>
                <li class="list-group-item">
                    <b>Keterangan</b> <a class="float-right">{{ currentUser.keterangan }}</a>
                </li>
                </ul>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active show" href="javascript:void(0)" data-toggle="tab">
                            <i class="fas fa-user-circle mr-2"></i> Profil Anda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editprofile" v-model="editing">
                                <label class="form-check-label" for="editprofile">Edit Profil</label>
                            </div>
                        </a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                <div class="tab-pane active show" id="settings">
                    <form class="form-horizontal" @submit.prevent="updateProfile">
                        <div class="form-group">
                            <label for="profilenama">Nama</label>
                            <input type="text" class="form-control" 
                                :class="{ 'is-invalid': profile.errors.has('nama') }" 
                                id="profilenama" v-model="profile.nama" :disabled="!editing"
                                >
                            <has-error :form="profile" field="nama"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="profileusername">Username</label>
                            <input type="text" class="form-control" 
                                :class="{ 'is-invalid': profile.errors.has('username') }" 
                                id="profileusername" v-model="profile.username" :disabled="!editing"
                                >
                            <has-error :form="profile" field="username"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="profilpassword">Password</label>
                            <input type="password" class="form-control" 
                                :class="{ 'is-invalid': profile.errors.has('password') }" 
                                id="profilpassword" v-model="profile.password" :disabled="!editing"
                                >
                            <has-error :form="profile" field="password"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Foto Profil ( Ukuran &lt; 2MB )</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profilefoto"
                                        @change="changeFoto" :disabled="!editing">
                                    <label class="custom-file-label" for="profilefoto">
                                        {{ currentFoto }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-secondary float-right" type="submit" v-if="editing">
                            <i class="fas fa-check-circle mr-2"></i> Perbarui Data
                        </button>
                    </form>
                </div>
                <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</template>

<script>
    export default {
        data() {
            return {
                editing: false,
                fotoName: '',
                profile: new Form({
                    id_user: '',
                    nip: '',
                    nama: '',
                    username: '',
                    password: null,
                    foto: ''
                })
            }
        },

        created() {
            this.setData()
        },

        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            },

            currentFoto() {
                if (this.fotoName=='') {
                    return this.profile.foto
                }else{
                    return this.fotoName
                }
            }
        },

        methods: {
            setData() {
                this.profile.id_user = this.$store.getters.currentUser.id_user
                this.profile.nip = this.$store.getters.currentUser.nip
                this.profile.nama = this.$store.getters.currentUser.nama
                this.profile.username = this.$store.getters.currentUser.username
                this.profile.foto = this.$store.getters.currentUser.foto
            },
            changeFoto(event) {
                let file = event.target.files[0]
                let reader = new FileReader()

                if (file.type=='image/png' || file.type=='image/jpeg') {
                    if (file.size < 2097152) {
                        reader.onload = (event) => {
                            this.profile.foto = reader.result
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

            updateProfile() {
                this.$Progress.start()
                this.profile.put('api/update-profile')
                .then((response) => {
                    if (response.status==200) {
                        this.$Progress.finish()
                        swal({
                            title: 'Profil telah diperbarui',
                            text: "Login kembali untuk mendapatkan pembaruan profil",
                            type: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Logout'
                            }).then((result) => {
                            if (result.value) {
                                this.$Progress.start()
                                axios.post('api/logout')
                                .then((response) => {
                                    if (response.status==200) {
                                        this.$store.commit('logout');
                                        this.$router.push({name: 'Login'})
                                        this.$Progress.finish()
                                    }
                                })
                                .catch((error) => {
                                    console.log(error)
                                })
                            }
                        })
                    }
                })
                .catch((error) => {
                    console.log(error)
                    this.$Progress.fail()
                })
            }
        }
    }
</script>

