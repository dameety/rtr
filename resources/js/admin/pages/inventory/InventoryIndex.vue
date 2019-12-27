<template>
    <div>

        <div class="top-section">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Inventory</h2>

                    <b-button :to="{name: 'inventory.create' }">
                        <i class="fas fa-trash "></i> Create New
                    </b-button>
                </div>

            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <resource-table
                    resource-name='meals'
                    :fields="fields"
                    ref="table"
                    resource-title="Meals"
                >
                    <template
                        v-slot:cell(actions)="scope"
                    >
                        <b-dropdown
                            size="sm"
                            variant="link"
                            no-caret
                            class="dropdown-ellipses">

                            <template slot="button-content">
                                <i class="text-muted fas fa-ellipsis-v" dusk="action-dropdown"></i>
                            </template>

                            <b-dropdown-item
                                :dusk="`delete-meal-${scope.item.id}`"
                                @click="removeItem(scope.item)">
                                <span class="text-danger">
                                  <i class="fas fa-trash text-danger"></i> Delete
                                </span>
                            </b-dropdown-item>

                            <b-dropdown-item
                                :dusk="`edit-meal-${scope.item.id}`"
                                :to="{name:'inventory.edit', params: {id: scope.item.id}}">
                                <span>
                                  <i class="fas fa-trash "></i> Edit
                                </span>
                            </b-dropdown-item>

                        </b-dropdown>
                    </template>

                    <template v-slot:cell(price)="scope">
                        {{ scope.value }}
                    </template>


                    <template v-slot:cell(description)="scope">
                        {{ scope.value }}
                    </template>

                    <template v-slot:cell(name)="scope">
                        {{ scope.value }}
                    </template>

                    <template v-slot:cell(units)="scope">
                        {{ scope.value }}
                    </template>

                    <template v-slot:cell(created_at)="scope">
                        {{ scope.value }}
                    </template>
                </resource-table>

            </div>
        </div>


    </div>
</template>

<script>
    import ResourceTable from "@/admin/components/ResourceTable";
    import PopupMixins from "@/mixins/PopupMixins";
    import * as types from "@/store/constant"

    export default {
        name: "InventoryIndex",

        mixins: [PopupMixins],

        components: {
            ResourceTable
        },

        data:()=>({
            fields: [
                {
                    key: "name",
                    tdClass: "text-muted"
                },

                {
                    key: "description",
                    tdClass: "text-muted"
                },
                {
                    key: "price",
                    tdClass: "text-muted"
                },
                {
                    key: "units",
                    tdClass: "text-muted"
                }
            ]
        }),
        methods:{
            async deleteItem(item) {
                try {
                    this.$data.$_isLoading = true;
                    await this.$http.delete(types.MEAL_API + '/' + item.id);
                    this.$refs.table.refreshData();
                    this.$data.$_isLoading = false;
                } catch (e) {
                    this.$_flashError();
                }
            },

            removeItem(item) {
                this.$_confirmModal(
                    "Are you sure you want to delete this item?",
                    value => {
                        if (value) {
                            this.deleteItem(item);
                        }
                    }
                );
            }
        }
    }
</script>

<style lang="scss" scoped>
    .top-section {
        padding: 20px;
        background-color: #f7f9fe;

        a.btn-secondary {
            background-color: #5C69D1;
            color: #fff;
        }

        .page-title {
            font-size: 30px;
            font-weight: 600;
            color: #3c3957;
        }
    }

    .bottom-section {
        padding-top: 20px;
        padding-bottom: 20px;

        .header-table {
            background-color: #fff;
            margin-bottom: 20px;
        }

        table {
            p {
                margin-bottom: 0;
            }
        }
    }
</style>
