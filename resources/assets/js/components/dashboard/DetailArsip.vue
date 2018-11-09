<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        List Arsip SP2D terbaru
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="ars in arsip" :key="ars.id_arsip">{{ ars.surat.nomor_surat }}</li>
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
                arsip: {}
            }
        },
        created() {
            axios.get('api/detail-arsip')
            .then((response) => {
                this.arsip = response.data.data.data
            })
            .catch((error) => {
                console.log(error)
            })
        }
    }
</script>
