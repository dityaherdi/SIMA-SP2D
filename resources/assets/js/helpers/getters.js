export function getGedung() {
    let gedung = {}
    axios.get('api/get-gedung')
        .then((response) => {
            this.gedung = response.data.data
        })
        .catch((error) => {
            console.log(error)
    })
    return gedung
}

export function getRuangan() {
    let ruangan = {}
    axios.get('api/get-ruangan')
    .then((response) => {
        this.ruangan = response.data.data
    })
    .catch((error) => {
        console.log(error)
    })
    return ruangan
}