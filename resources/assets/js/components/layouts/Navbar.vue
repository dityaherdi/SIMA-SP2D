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
        <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fa fa-search"></i>
            </button>
            </div>
        </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <i class="fas fa-cogs mr-2"></i> Pengaturan
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-dark">
            <a href="javascript:void(0)" class="dropdown-item bg-dark">
                <i class="fa fa-user-circle mr-2"></i> Profil
            </a>
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
        methods: {
            logout() {
                this.$Progress.start()
                this.$store.commit('logout');
                this.$router.push({name: 'Login'})
                this.$Progress.finish()
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        }
    }
</script>

