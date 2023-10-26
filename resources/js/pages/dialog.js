
// SweetAlert2, for more examples you can check out https://github.com/sweetalert2/sweetalert2
class pageDialogs {
    /*
     * SweetAlert2 demo functionality
     *
     */
    static sweetAlert2() {
        // Set default properties
        let toast = Swal.mixin({
            buttonsStyling: false,
            target: '#page-container',
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-danger m-1',
                input: 'form-control'
            }
        });

        // Init an example confirm dialog on button click
        document.querySelector('#confim-modify-connection-dialog').addEventListener('click', e => {
            toast.fire({
                title: 'Are you sure?',
                text: "Are you sure to change pump's mode?",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                confirmButtonText: 'Yes, Proceed!',
                html: false,
            }).then(result => {
                if (result.value) {
                    $("#modify-pump-connection-form").submit()
                } else if (result.dismiss === 'cancel') {
                    return false;
                }
            });
        });
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.sweetAlert2();
    }
}

// Initialize when page loads
Dashmix.onLoad(() => pageDialogs.init());