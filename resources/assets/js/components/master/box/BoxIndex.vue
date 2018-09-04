<template>
    <div>
        <button type="button" class="btn btn-primary" @click="newSkpdModal()">
            Tambah Data SKPD
        </button>
        <modal-skpd></modal-skpd>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        components: {
          "modal-skpd": require('./children/SkpdModal.vue')
        },
        
        methods: {
            newSkpdModal() {
                this.$emit('new_skpd')
            }
        }
    }
</script>