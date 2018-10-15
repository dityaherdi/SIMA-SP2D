<template>
<div>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="javascript:void(0)" class="brand-link">
        <img src="/img/logo.png" alt="SIMA - SP2D Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">SIMA - SP2D</span>
      </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="javascript:void(0)" class="d-block"> {{ currentUser }} </a>
          </div>
        </div>
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item" @click="forceCloseModalOpen">
              <router-link to="/dashboard" class="nav-link">
                <i class="fas fa-tachometer-alt nav-icon"></i>
                <p>Dashboard</p>
              </router-link>
            </li>
            <li class="nav-item has-treeview" :class="{'menu-open' : menuOpen}" @click="forceCloseModalOpen">
              <a href="javascript:void(0)" @click="menuOpen = !menuOpen" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Master Data
                  <i class="right fas fa-angle-down"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/skpd" class="nav-link">
                    <i class="fas fa-address-card nav-icon"></i>
                    <p>SKPD</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/gedung" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Gedung</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/ruangan" class="nav-link">
                    <i class="fas fa-door-open nav-icon"></i>
                    <p>Ruangan</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/rak" class="nav-link">
                    <i class="fas fa-archive nav-icon"></i>
                    <p>Rak</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/box" class="nav-link">
                    <i class="fas fa-box-open nav-icon"></i>
                    <p>Box</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/jenis-surat" class="nav-link">
                    <i class="fas fa-table nav-icon"></i>
                    <p>Jenis Surat</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/surat" class="nav-link">
                    <i class="fas fa-envelope nav-icon"></i>
                    <p>Surat</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/arsip" class="nav-link">
                    <i class="fas fa-file-archive nav-icon"></i>
                    <p>Arsip</p>
                  </router-link>
                </li>
                <li class="nav-item" @click="forceCloseModalOpen">
                  <router-link to="/user" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>User</p>
                  </router-link>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
</div>
</template>

<script>

export default {
    name: "menu-vue",
    data() {
        return {
            menuOpen: false
        }
    },

    computed: {
        currentUser() {
            return this.$store.getters.currentUser.nama;
        },
        currentModal() {
            return this.$store.getters.modalOpen
        }
    },
    
    methods: {
        forceCloseModalOpen() {
            if (this.currentModal=='') {
                return
            }else {
                this.forceCloseModal(this.currentModal)
                this.$store.dispatch('modalOpen', '')
            }
        }
    }
}
</script>

