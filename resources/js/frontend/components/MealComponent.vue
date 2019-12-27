<template>

    <div class="card mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="front/img/single_food_1.png" class="card-img" alt="meal picture">
            </div>
            <div class="col-md-9">
                <div class="card-body d-flex flex-column mb-sauto justify-content-between">
                    <div>
                        <h6 class="card-title">{{meal.name}}</h6>
                        <p class="card-text">
                            {{meal.description}}
                        </p>
                    </div>

                    <div class="d-flex align-items-end justify-content-between">
                        <p class="text-muted">{{meal.price | currency}}</p>

                        <button type="button" dusk="add-to-cart-button" class="btn btn-dark btn-sm" @click.prevent="addToCart()">
                            Add To Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MealComponent",
        props: {
            meal: {}
        },
        methods: {
            addToCart() {
                this.$emit('addToCart', this.meal)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card-body {
        height: 100%;
        padding: 10px 10px;
        h6, p {
            margin-bottom: 0;
        }
        p {
            font-size: 14px;
        }
        .col-md-9 {
            padding-left: 0;
        }

        button {
            text-transform: capitalize;
        }
    }
</style>
