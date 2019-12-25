<template>
    <div>

        <div class="top-section">
            <div class="container">

                <div>
                    <h2 class="page-title">Edit Meal #{{inventory.id}}</h2>
                </div>

            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <InventoryForm
                        v-model="inventory"
                        @saved="saved"
                        action="update"
                        v-if="inventory"
                ></InventoryForm>

            </div>
        </div>

    </div>
</template>

<script>
    import InventoryForm from "@/admin/pages/inventory/InventoryForm";
    import * as types from "@/store/constant"

    export default {
        name: "InventoryEdit",

        components: {
            InventoryForm
        },

        data() {
            return {
                inventory: {}
            };
        },

        created () {
            this.loadMeal();
        },

        methods: {
            saved() {
                this.$router.push({ name: "inventory.index" });
            },

            async loadMeal() {
                try {
                    const resp = await this.$http.get(types.MEAL_API + '/' + this.$route.params.id);
                    this.inventory = resp.data.data.meal;
                } catch (e) {
                    console.error(e);
                    return [];
                }
            },
        }
    };
</script>

<style lang="scss" scoped>
    .top-section {
        padding: 20px;
        background-color: #f7f9fe;

        .page-title {
            font-size: 30px;
            font-weight: 600;
            color: #3c3957;
        }
    }

    .bottom-section {
        padding-top: 20px;
        padding-bottom: 20px;
    }
</style>
