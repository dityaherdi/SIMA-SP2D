export function showModal(form, entity, operation, data) {
    this.$store.dispatch('modalOpen', entity)
    if (operation=='create') {
        this.editing = false
        form.reset()
        form.clear()
        $('#'+entity+'Modal').modal('show')
    }else if (operation=='edit') {
        this.editing = true
        form.reset()
        form.clear()
        form.fill(data)
        $('#'+entity+'Modal').modal('show')
    }else if (operation=='detail') {
        $('#detail'+entity+'Modal').modal('show')
    }
}

export function forceCloseModal(entity) {
    $('#'+entity+'Modal').modal('hide')
    $('#detail'+entity+'Modal').modal('hide')
}