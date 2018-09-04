<template>
    <!-- Modal -->
    <div class="modal fade" id="skpdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data SKPD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Kode SKPD</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="0.00.00.">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nama SKPD</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="SKPD">
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Tambah SKPD</button>
                </div>

              </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.$parent.$on('new_skpd', () => {
                $('#skpdModal').modal('show')
            })
        }
    }
</script>