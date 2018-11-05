<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-dark navbar-dark border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
        </li>
        </ul>

        <!-- SEARCH FORM -->
        <div class="input-group input-group-sm ml-3" style="width: 350px" v-if="currentPath!='/dashboard'">
            <input class="form-control form-control-navbar white-text-color"
                    type="search" placeholder="Pencarian" aria-label="Search"
                    v-model="keywords"
                    @keyup.enter="search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit" @click="search">
                <i class="fa fa-search"></i>
            </button>
            </div>
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <i class="fas fa-cogs mr-2"></i> Pengaturan
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-dark">
            <router-link :to="{ name: 'Profil' }" class="dropdown-item bg-dark">
                <i class="fa fa-user-circle mr-2"></i> Profil
            </router-link>
            <div class="dropdown-divider"></div>
            <template v-if="currentUser">
                <a href="javascript:void(0)" class="dropdown-item dropdown-footer bg-dark" @click="logout">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </a>
            </template>
            </div>
        </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</template>

<script>
    export default {
        name: "navbar-vue",

        data() {
            return{
                keywords: ''
            }
        },

        watch:{
            $route (to, from){
                this.keywords = ''
            }
        },

        created() {
            Signal.$on('clear_keywords', () => {
                this.keywords = ''
            })
        },

        methods: {
            logout() {
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
            },

            search() {
                if (this.keywords=='') {
                    swal({
                        text: 'Kata kunci pencarian masih kosong',
                        type: 'warning'
                    })
                }else{
                    Signal.$emit(this.currentPath+'-search', this.keywords)
                }
            }
        },

        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            },

            currentPath() {
                return this.$route.path
            }
        }
    }
</script>

