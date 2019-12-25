<template>
    <div>

        <div class="top-section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Deliveries</h2>
                </div>
            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <resource-table
                    resource-name='deliveries'
                    :fields="fields"
                    ref="table"
                    resource-title="Deliveries">

                    <template
                        v-slot:cell(actions)="scope">
                        <b-dropdown
                            size="sm"
                            variant="link"
                            no-caret
                            class="dropdown-ellipses">

                            <template slot="button-content">
                                <i class="text-muted fas fa-ellipsis-v"></i>
                            </template>

                            <b-dropdown-item
                                :to="{name:'orders.show', params: {id: scope.item.id}}">
                                <span>
                                  <i class="fas fa-trash "></i> View
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

    export default {
        name: "DeliveryIndex",

        components: {
            ResourceTable
        },

        mixins: [PopupMixins],

        data:()=>({
            fields: [
                {
                    key: 'customer',
                    tdClass: "text-muted"
                },
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
        })
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
