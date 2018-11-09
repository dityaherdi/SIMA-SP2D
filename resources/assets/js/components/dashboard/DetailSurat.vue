<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        List SP2D terbaru
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="sur in surat" :key="sur.id_surat">{{ sur.nomor_surat }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                surat: {}
            }
        },
        created() {
            axios.get('api/detail-surat')
            .then((response) => {
                this.surat = response.data.data.data
            })
            .catch((error) => {
                console.log(error)
            })
        }
    }
</script>
