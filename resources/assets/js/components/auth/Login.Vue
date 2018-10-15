<template>
    <div class="login-box">
        <div class="login-logo">
            <img src="/img/logo.png" style="width: 75px;">
            <p><b>SIMA - </b>SP2D</p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <p class="login-box-msg">Login Administrator</p>
            <form method="post" @submit.prevent="authenticate">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" v-model="form.username">
                    <div class="input-group-append">
                        <span class="fas fa-user-tie input-group-text"></span>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                    <div class="input-group-append">
                        <span class="fas fa-key input-group-text"></span>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                </div>
            </form>
            </div>
        </div>
        <p class="text-center" style="font-style: italic;">Badan Pengelola Keuangan<br>
            dan Aset Daerah (BPKAD) Provinsi Bali<br>
            {{ year }}
        </p>
    </div>
    <!-- /.login-box -->
</template>

<script>
    import {login} from '../../helpers/auth';
    export default {
        name: 'login',
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                loginError: null,
                year: currentYear
            }
        },

        methods: {
            authenticate() {
                this.$Progress.start()
                this.$store.dispatch('login');
                login(this.$data.form)
                    .then((response) => {
                        this.$store.commit('loginSuccess', response)
                        this.$router.push({ name: 'Dashboard' })
                        toast({
                            type: 'success',
                            title: 'Selamat Datang '+this.$store.state.currentUser.nama
                        })
                        this.$Progress.finish()
                    })
                    .catch((error) => {
                        this.$store.commit('loginFailed', {error});
                        this.$Progress.fail()
                        swal({
                            title: 'Error!',
                            text: this.$store.getters.authError,
                            type: 'error'
                        })
                });
            }
        }
    }
</script>
