export default {
    methods: {
        $_flashError(message) {
            this.$bvToast.toast(message, {
                title: `Error`,
                variant: "error",
                toaster: "b-toaster-top-right",
                solid: true
            });
        },
        $_flashWarning(message) {
            this.$bvToast.toast(message, {
                variant: "warning",
                toaster: "b-toaster-top-right",
                solid: true
            });
        },
        $_flashSuccess(message) {
            this.$bvToast.toast(message, {
                title: `Success`,
                variant: "success",
                toaster: "b-toaster-top-right",
                solid: true
            });
        },
        $_confirmModal(message, callback, options) {
            this.$bvModal
                .msgBoxConfirm(message, {
                    title: "Delete resource",
                    size: "sm",
                    buttonSize: "sm",
                    okTitle: "Yes! Delete it",
                    cancelTitle: "No",
                    okVariant: "danger",
                    headerClass: "border-bottom-0",
                    footerClass: "bg-light border-top-0",
                    centered: true,
                    ...options
                })
                .then(value => {
                    callback(value);
                });
        }
    }
}
