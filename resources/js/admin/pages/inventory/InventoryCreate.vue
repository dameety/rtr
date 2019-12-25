<template>
    <div>

        <div class="top-section">
            <div class="container">

                <div>
                    <h2 class="page-title">Create Inventory</h2>
                </div>

            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <InventoryForm
                    v-model="inventory"
                    @saved="saved"
                    v-if="inventory"
                ></InventoryForm>

            </div>
        </div>

    </div>
</template>

<script>
    import InventoryForm from "@/admin/pages/inventory/InventoryForm";

    export default {
        name: "InventoryCreate",

        components: {
            InventoryForm
        },

        data() {
            return {
                inventory: null
            };
        },

        mounted() {
            this.inventory = {
                name: "",
                units: 0,
                description: "",
                price: 0
            };
        },

        methods: {
            saved() {
                this.$router.push({ name: "inventory.index" });
            }
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
