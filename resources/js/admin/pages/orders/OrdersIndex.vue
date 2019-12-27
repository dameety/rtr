<template>
    <div>

        <div class="top-section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Orders</h2>

                    <b-button class="btn-primary" @click.prevnet="makeNewOrder()">
                         Make New Order
                    </b-button>
                </div>
            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <resource-table
                    resource-name='orders'
                    :fields="fields"
                    ref="table"
                    resource-title="Orders">

                    <template
                        v-slot:cell(actions)="scope">
                        <b-dropdown
                            size="sm"
                            variant="link"
                            no-caret
                            class="dropdown-ellipses">

                            <template slot="button-content">
                                <i class="text-muted fas fa-ellipsis-v" dusk="action-dropdown"></i>
                            </template>

                            <b-dropdown-item
                                :dusk="`delete-order-${scope.item.id}`"
                                @click="removeItem(scope.item)"
                                v-if="$store.getters.userIsAdmin">
                                <span class="text-danger">
                                  <i class="fas fa-trash text-danger"></i> Delete
                                </span>
                            </b-dropdown-item>


                            <b-dropdown-item
                                :dusk="`edit-order-${scope.item.id}`"
                                :to="{name:'orders.edit', params: {id: scope.item.id}}"
                                v-if="$store.getters.userIsAdmin">
                                <span>
                                  Edit
                                </span>
                            </b-dropdown-item>

                            <b-dropdown-item
                                :dusk="`view-order-${scope.item.id}`"
                                :to="{name:'orders.show', params: {id: scope.item.id}}"
                                v-if="!$store.getters.userIsAdmin">
                                <span>
                                   View
                                </span>
                            </b-dropdown-item>

                        </b-dropdown>
                    </template>

                    <template v-slot:cell(total_amount)="scope">
                        {{ scope.value | currency }}
                    </template>

                    <template v-slot:cell(status)="scope">
                        {{ scope.value }}
                    </template>

                    <template v-slot:cell(created_at)="scope">
                        {{ scope.value | date}}
                    </template>

                    <template v-slot:cell(delivered_at)="scope">
                        {{ scope.value | date}}
                    </template>

                    <template v-slot:cell(customer)="scope">
                        {{ scope.item.customer.name }}
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
        name: "OrderIndex",

        components: {
            ResourceTable
        },

        mixins: [PopupMixins],

        data:()=>({
            fields: [
                {
                    key: "total_amount",
                    tdClass: "text-muted"
                },
                {
                    key: "status",
                    tdClass: "text-muted"
                },
                {
                    key: "created_at",
                    tdClass: "text-muted"
                },
                {
                    key: "delivered_at",
                    tdClass: "text-muted"
                }
            ]
        }),

        mounted () {
            if(this.$store.getters.userIsAdmin) {
                this.fields.unshift({
                    key: 'customer',
                    tdClass: "text-muted"
                })
            }
        },

        methods:{
            async deleteItem(item) {
                try {
                    this.$data.$_isLoading = true;
                    await this.$http.delete(types.ORDER_API + '/' + item.id);
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
            },

            makeNewOrder () {
                window.location.assign(window.location.origin)
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
    }
</style>
