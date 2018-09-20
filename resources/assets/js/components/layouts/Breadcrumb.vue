<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">HOME</li>
                    <li class="breadcrumb-item" aria-current="page">{{ activePage | breadcrumbActive | uppercase}}</li>
                </ol>
            </nav>
        </div>
    </div>
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

