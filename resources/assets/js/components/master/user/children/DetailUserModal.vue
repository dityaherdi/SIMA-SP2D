<template>
    <!-- Modal -->
    <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img :src="'./img/profile/'+user.foto" alt="Foto Profil User" class="qr-img-detail">
                </div>
                <div class="col-md-6">
                    <p class="test-justify"><strong>NIP :</strong> {{ user.nip }} </p>
                    <p class="test-justify"><strong>Nama :</strong> {{ user.nama }} </p>
                    <p class="test-justify"><strong>Username :</strong> {{ user.username }} </p>
                    <p class="test-justify"><strong>Tipe : </strong> {{ user.tipe }} </p>
                    <p class="test-justify"><strong>Keterangan : </strong> {{ user.keterangan }} </p>
                    <p class="test-justify"><strong>Status : </strong> {{ user.status }} </p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-window-close mr-2"></i> Tutup
            </button>
        </div>
        </div>
    </div>
    </div>    
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    nip: '',
                    nama: '',
                    username: '',
                    tipe: '',
                    foto: '',
                    keterangan: '',
                    status: ''
                }
            }
        },

        created() {
            Signal.$on('show_detail_user_modal', (user) => {
                this.user.nip = user.nip
                this.user.nama = user.nama
                this.user.username = user.username
                this.user.tipe = user.tipe
                this.user.foto = user.foto
                if (user.keterangan==null) {
                    this.user.keterangan = '-'
                } else {
                    this.user.keterangan = user.keterangan
                }
                if (user.status===1) {
                    this.user.status = 'Aktof'
                } else if(user.status===0) {
                    this.user.status = 'Non-Aktif'
                }
                this.showModal(null, 'User', 'detail', null)
            })
        }
    }
</script>

