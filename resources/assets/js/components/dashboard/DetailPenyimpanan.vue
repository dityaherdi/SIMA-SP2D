<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Detail Penyimpanan</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Jumlah Gedung : {{ storage.countedGed }}
                                <router-link :to="{ name: 'GedungIndex' }" 
                                    v-if="!this.isPimpinan()"
                                    tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-building mr-2 float-left"></i> Semua Gedung
                                </router-link>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Jumlah Ruangan : {{ storage.countedRua }}
                                <router-link :to="{ name: 'RuanganIndex' }" 
                                    v-if="!this.isPimpinan()"
                                    tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-door-open mr-2 float-left"></i> Semua Ruangan
                                </router-link>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Jumlah Rak : {{ storage.countedRak }}
                                <router-link :to="{ name: 'RakIndex' }"
                                    v-if="!this.isPimpinan()"
                                    tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-archive mr-2 float-left"></i> Semua Rak
                                </router-link>
                            </a>
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Jumlah Box : {{ storage.countedBox }}
                                <router-link :to="{ name: 'BoxIndex' }"
                                    v-if="!this.isPimpinan()"
                                    tag="span" class="btn btn-primary btn-block col-sm-4">
                                    <i class="fas fa-box-open mr-2 float-left"></i> Semua Box
                                </router-link>
                            </a>
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
