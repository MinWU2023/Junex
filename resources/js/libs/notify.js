class Notify {
    success (message, th) {
        th.$notify({
            title: th.$t('success'),
            message: message,
            type: 'success',
            duration: 2000
        })
    }

    dange (message, th) {
        th.$notify({
            title: th.$t('error'),
            message: message,
            type: 'error',
            duration: 2000
        })
    }

    doSuccess (th) {
        this.success(th.$t('success'), th)
    }
    doError (message, th) {
        this.dange(message, th)
    }
    createSuccess (th) {
        this.success(th.$t('createSuccess'), th)
    }

    editSuccess (th) {
        this.success(th.$t('editSuccess'), th)
    }

    deleteSuccess (th) {
        this.success(th.$t('deleteSuccess'), th)
    }
}

export default new Notify()
