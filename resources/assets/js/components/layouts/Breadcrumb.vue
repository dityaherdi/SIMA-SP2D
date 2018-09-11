<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ activePage | breadcrumbActive | uppercase}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ activePage | breadcrumbActive}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</template>
<script>
    export default {

        watch:{
            $route (to, from){
                this.$store.commit('changePage', this.$route.path);
            }
        },

        computed: {
            activePage() {
                return this.$store.getters.activePage;
            }
        }
    }
</script>

