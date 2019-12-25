<template>
    <div>

        <form @submit.prevent="submitForm()"
            v-if="value">

            <div class="row">
                <div class="col-sm-8">
                    <div class="card">

                        <ValidationErrorsDisplay v-model="serverErrors" />

                        <div>

                            <div class="form-group">
                                <label
                                        for="name"
                                        class="col-form-label"
                                >Name</label>
                                <input
                                        id="name"
                                        type="text"
                                        v-model="value.name"
                                        class="form-control"
                                >
                            </div>

                            <div class="form-group">
                                <label
                                        for="price"
                                        class="col-form-label"
                                >Price</label>
                                <input
                                        id="price"
                                        type="number"
                                        v-model="value.price"
                                        class="form-control"
                                >
                            </div>


                            <div class="form-group">
                                <label
                                        for="number"
                                        class="col-form-label"
                                >Units</label>
                                <input
                                        id="number"
                                        type="text"
                                        v-model="value.units"
                                        class="form-control"
                                >
                            </div>

                            <div class="form-group">
                                <label
                                        for="description"
                                        class="col-form-label"
                                >Description</label>
                                <textarea
                                        id="description"
                                        v-model="value.description"
                                        class="form-control"
                                ></textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <loading-button
                    loading-text="Saving..."
                    button-text="Save"
                    :is-loading="submitting"
            ></loading-button>

        </form>

    </div>
</template>

<script>
    import LoadingButton from "@/components/LoadingButton";
    import PopupMixins from "@/mixins/PopupMixins";
    import * as types from "@/store/constant";

    export default {
        name: "InventoryForm",

        mixins: [PopupMixins],

        props: {
            value: {
                required: true
            },
            action: {
                type: String,
                default: "create"
            }
        },

        components: {
            LoadingButton
        },

        data() {
            return {
                submitting: false,
                serverErrors: null
            };
        },

        methods: {
            async submitForm() {
                this.submitting = true;
                this.serverErrors = null;

                try {
                    let resp = null;
                    if(this.action === 'update') {
                        resp = await this.$http.put(`${types.MEAL_API}/${this.value.id}`, this.value);
                    } else {
                        resp = await this.$http.post(types.MEAL_API, this.value);
                    }
                    this.submitting = false;

                    setTimeout(() => {
                        this.$_flashSuccess(resp.data.message);
                    }, 0);

                    this.$emit('saved', {item: resp});

                } catch (error) {
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
                }
            }
        }
    };
</script>

<style scoped>
</style>
