<template>
    
    <footer class="main-footer bg-dark">
        <div class="float-right d-none d-sm-inline">
        SIMA - SP2D
        </div>
        <strong>Copyright &copy; {{ year }} </strong> BPKAD Provinsi Bali.
    </footer>
    
</template>

<script>
    export default {
        data() {
            return {
                year: currentYear
            }
        }
    }
</script>

