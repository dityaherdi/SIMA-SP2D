export function getGedung() {
    return axios.get('api/get-gedung')
        .then((response) => {
            return response.data.data
        })
        .catch((error) => {
            console.log(error)
    })
}

export function getRuangan(id) {
    return axios.get('api/get-ruangan/'+id)
        .then((response) => {
            return response.data.data
        })
        .catch((error) => {
            console.log(error)
    })
}

export function getRak(id) {
    return axios.get('api/get-rak/'+id)
        .then((response) => {
            return response.data.data
        })
        .catch((error) => {
            console.log(error)
    })
}

export function getBox(id) {
    return axios.get('api/get-box/'+id)
        .then((response) => {
            return response.data.data
        })
        .catch((error) => {
            console.log(error)
    })
}