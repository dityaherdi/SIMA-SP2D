export function createData(form, url, entity) {
    this.$Progress.start()
    form.post(url)
    .then((response) => {
        if (response.status==200) {
            $('#'+entity+'Modal').modal('hide')
            Signal.$emit('load_'+entity+'')
            toast({
                type: 'success',
                title: response.data.message
            })
            this.$Progress.finish()
        }
    })
    .catch((error) => {
        console.log(error)
        this.$Progress.fail()
    })
}

export function readData(url) {
    return axios.get(url)
    .then((response) => {
        return response.data.data
    }).catch((error) => {
        console.log(error)
    })
}

export function updateData(form, url, entity) {
    this.$Progress.start()
    form.put(url)
    .then((response) => {
        if (response.status==200) {
            $('#'+entity+'Modal').modal('hide')
            Signal.$emit('load_'+entity+'')
            toast({
                type: 'success',
                title: response.data.message
            })
            this.$Progress.finish()
        }
    })
    .catch((error) => {
        this.$Progress.fail()
        console.log(error)
    })
}

export function deleteData(url, entity) {
    swal({
        title: 'Hapus data '+entity+' ini?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Data',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            this.$Progress.start()
            axios.delete(url)
            .then((response) => {
                if (response.status == 200) {
                    Signal.$emit('load_'+entity+'')
                    toast({
                        type: 'success',
                        title: response.data.message
                    })
                    this.$Progress.finish()
                }
            })
            .catch((error) => {
                this.$Progress.fail()
                console.log(error)
            })
        }
    })
}