<template>
    <div>

        <div class="top-section">
            <div class="container">

                <div>
                    <h2 class="page-title">Order #{{order.id}}</h2>
                </div>

            </div>
        </div>


        <div class="bottom-section">
            <div class="container">

                <div class="row">
                    <div class="col-7">
                        <div class="card order">
                            <div class="card-header">
                                Details
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-5">
                                        Total amount
                                    </div>

                                    <div class="col-7">
                                        {{order.total_amount | currency}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        Customer
                                    </div>

                                    <div class="col-7">
                                        {{customer.name}}, {{customer.email}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        Driver
                                    </div>

                                    <div class="col-7" v-if="driver">
                                        {{driver.name}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        Status
                                    </div>

                                    <div class="col-7">
                                        {{order.status}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        Ordered at
                                    </div>

                                    <div class="col-7">
                                        {{order.created_at}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        Address
                                    </div>

                                    <div class="col-7">
                                        {{order.address}}
                                    </div>
                                </div>

                                <div class="row">
                                    <b-list-group flush class="w-100">
                                        <b-list-group-item class="d-flex justify-content-between align-items-center">
                                            Meals
                                        </b-list-group-item>

                                        <template v-for="meal in order.cart">

                                            <b-list-group-item class="d-flex justify-content-between align-items-center">
                                                {{meal.name}}
                                                <b-badge variant="secondary" pill>
                                                    {{meal.price | currency}} * {{meal.quantity}}
                                                </b-badge>
                                            </b-list-group-item>

                                        </template>
                                    </b-list-group>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-5 ml-auto">

                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import * as types from "@/store/constant";
    import PopupMixins from "@/mixins/PopupMixins";

    export default {
        name: "OrdersShow",

        mixins: [PopupMixins],

        data() {
            return {
                order: {},
                customer: {},
                driver: {}
            };
        },

        created () {
            this.loadOrder();
        },

        methods: {
            setOrderDetails(resp) {
                this.order = resp.data.data.order;
                this.driver = resp.data.data.order.driver;
                this.customer = resp.data.data.order.customer;
                this.selectedDriverId = this.driver ? this.driver.id : null;
            },

            async loadOrder() {
                try {
                    const resp = await this.$http.get(types.ORDER_API + '/' + this.$route.params.id);

                    this.setOrderDetails(resp);

                } catch (e) {
                    console.error(e);
                    return [];
                }
            }
        },
    }
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

        .order {
            .row {
                padding-top: 20px;
                padding-bottom: 20px;
            }
        }

    }
</style>
