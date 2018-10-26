export function isMaster() {
    return this.$store.state.currentUser.tipe === 'Master'
}

export function isAdmin() {
    return this.$store.state.currentUser.tipe === 'Admin'
}

export function isPimpinan() {
    return this.$store.state.currentUser.tipe === 'Pimpinan'
}

export function isMasterOrAdmin() {
    if (this.$store.state.currentUser.tipe === 'Master' || this.$store.state.currentUser.tipe === 'Admin') {
        return true
    }
}

export function isMasterOrPimpinan() {
    if (this.$store.state.currentUser.tipe === 'Master' || this.$store.state.currentUser.tipe === 'Pimpinan') {
        return true
    }
}