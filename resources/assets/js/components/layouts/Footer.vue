<template>
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
        SIMA - SP2D
        </div>
        <!-- Default to the left -->
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

