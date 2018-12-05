<template>
    <div>
        <div>
        <not-found v-if="!this.isMasterOrAdmin()"></not-found>
        <template v-else>
        <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Data User</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" @click="showCreatingModal" 
                        title="Tambah Data User">
                        <i class="fas fa-plus-square mr-2"></i> Tambah User
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-sm">
                    <tr v-if="isUserEmpty">
                        <td class="text-center" colspan="5">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    <tbody v-else>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Username</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                        <tr v-for="(user,index) in users.data" :key="user.id_user">
                            <td>{{ index + counter }}</td>
                            <td>{{ user.nip }}</td>
                            <td>{{ user.username }}</td>
                            <td>{{ user.tipe }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" 
                                    title="Lihat Detail User"
                                    @click="showDetailUserModal(user)">
                                    <i class="fas fa-eye mr-2"></i> Detail
                                </a>
                                
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" 
                                    title="Edit Data User"
                                    @click="showEditingModal(user)"> Edit
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- <a href="javascript:void(0)" class="btn btn-danger btn-sm" 
                                    title="Hapus Data User"
                                    @click="deleteUser(user.id_user)">
                                    <i class="fas fa-trash"></i>
                                </a> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                    <div class="float-left" v-if="searching">
                        <button class="btn btn-success btn-sm" @click="loadUser()">
                            <i class="fas fa-list-alt mr-2"></i> Semua User
                        </button>
                    </div>
                    <div class="float-right">
                        <pagination :data="users" @pagination-change-page="getResults" :limit="1"></pagination>
                    </div>
            </div>
            </div>
        </div>
        </div>
        <modal-user></modal-user>
        <modal-detail></modal-detail>
        </template>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                users: {},
                counter: 1,
                searching: false,
                userKeyword: null
            }
        },

        created() {
            Signal.$on('/user-search', (keywords) => {
                this.userKeyword = keywords
                this.searchUser(keywords)
            }),

            this.loadUser()
            Signal.$on('load_user', () => {
                this.loadUser()
            })
        },

        computed: {
            isUserEmpty() {
                if (typeof this.users.data == 'undefined' && this.users!=null) {
                    return false
                }else if (typeof this.users.data != 'undefined' && this.users.data.length==0) {
                    return true
                }
            }
        },

        components: {
            "modal-user": require('./children/UserModal.vue'),
            "modal-detail": require('./children/DetailUserModal.vue')
        },
        
        methods: {
            showCreatingModal() {
                Signal.$emit('show_creating_user_modal')
            },

            showEditingModal(user) {
                Signal.$emit('show_editing_user_modal', user)
            },

            showDetailUserModal(user) {
                Signal.$emit('show_detail_user_modal', user)
            },

            loadUser() {
                if (this.isMasterOrAdmin()) {
                    this.readData('api/user')
                    .then((users) => {
                        this.users = users
                        this.searching = false
                        this.userKeyword = null
                        Signal.$emit('clear_keywords')
                    })
                }
            },

            // deleteUser(id) {
            //     if (this.isMaster()) {
            //         this.deleteData('api/user/'+id, 'user')
            //     }
            // },

            getResults(page = 1) {
                if (this.isMasterOrAdmin()) {
                    if (this.searching==true) {
                        axios.get('api/search-user?keywords='+this.userKeyword+'&page='+page)
                        .then((response) => {
                            this.users = response.data.data
                            this.counter = response.data.data.from
                        })
                    } else {
                        axios.get('api/user?page='+page)
                        .then((response) => {
                            this.users = response.data.data
                            this.counter = response.data.data.from
                        })
                    }
                }
            },

            searchUser(keywords) {
                if (this.isMasterOrAdmin()) {
                    this.searchData('api/search-user?keywords='+keywords)
                    .then((user) => {
                        this.users = user
                        this.searching = true
                    })
                }
            }
        }
    }
</script>