<template>
    <main>

        <section class="section section-shaped section-lg">
            <div class="shape shape-style-1 bg-gradient-default">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="container pt-lg-md">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-body px-lg-5 py-lg-5">

                                <ValidationErrorsDisplay v-model="serverErrors" />

                                <form @submit.prevent="authenticate()">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Email" name="email" v-model="form_data.email" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" name="password" v-model="form_data.password" type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <loading-button
                                                loading-text="Authenticating..."
                                                button-text="Login"
                                                :is-loading="submitting"
                                        ></loading-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
    import LoadingButton from "@/components/LoadingButton";
    import * as types from "@/store/constant"
    import PopupMixins from "@/mixins/PopupMixins";

    export default {
        name: "Login.vue",

        components: {
            LoadingButton
        },

        mixins: [PopupMixins],

        data () {
            return {
                form_data: {
                    email: '',
                    password: '',
                },
                submitting: false,
                serverErrors: null
            }
        },

        methods: {

            authenticate () {
                this.submitting = true;
                this.serverErrors = null;

                this.$store
                    .dispatch(types.LOGIN_REQUEST, this.form_data)
                    .then(() => {
                        this.submitting = false;

                        window.location.assign(window.location.origin + '/admin/orders')
                    })
                    .catch((error) => {
                        this.submitting = false;

                        if (error.response) {
                            const errors = error.response.data['errors'];
                            const message = error.response.data['message'];
                            if (errors) {
                                this.serverErrors = Object.values(errors).flat();
                            } else {
                                this.$_flashError(message);
                            }
                        }
                    });
            }

        }
    }

</script>

<style scoped>

    button {
        text-transform: capitalize;
    }

</style>
