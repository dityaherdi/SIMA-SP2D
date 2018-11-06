<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Detail Penyimpanan</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jumlah Gedung : {{ storage.countedGed }}
                                <router-link :to="{ name: 'GedungIndex' }" tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-building mr-2 float-left"></i> Semua Gedung
                                </router-link>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jumlah Ruangan : {{ storage.countedRua }}
                                <router-link :to="{ name: 'RuanganIndex' }" tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-door-open mr-2 float-left"></i> Semua Ruangan
                                </router-link>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jumlah Rak : {{ storage.countedRak }}
                                <router-link :to="{ name: 'RakIndex' }" tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-archive mr-2 float-left"></i> Semua Rak
                                </router-link>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jumlah Box : {{ storage.countedBox }}
                                <router-link :to="{ name: 'BoxIndex' }" tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-box-open mr-2 float-left"></i> Semua Box
                                </router-link>
                            </li>
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
                storage: {}
            }
        },

        created() {
            this.countStorage()
        },

        methods: {
            countStorage() {
                axios.get('api/total-storage')
                .then((response) => {
                    this.storage = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
            },
        }
    }
</script>
