<template>
  <main>
    <div class="position-relative">
      <!-- shape Hero -->
      <section class="section section-lg section-shaped pb-250">
        <div class="shape shape-style-1 shape-default">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container py-lg-md d-flex">
          <div class="col px-0">
            <div class="row">
              <div class="col-lg-6">
                <h1 class="display-3  text-white">A beautiful Design System<span>completed with examples</span></h1>
              </div>
            </div>
          </div>
        </div>
        <!-- SVG separator -->
        <div class="separator separator-bottom separator-skew">
          <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </section>
      <!-- 1st Hero Variation -->
    </div>
    <section class="section section-lg pt-lg-0 mt--200">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row row-grid">
              <div class="col-lg-7">
                <div class="card shadow border-0">
                  <div class="card-body py-ss5">

                    <template v-for="meal in meals">
                      <MealComponent :meal="meal" @addToCart="updateCart"></MealComponent>
                    </template>

                  </div>
                </div>
              </div>
              <div class="col-lg-5 ml-auto">

                <ValidationErrorsDisplay v-model="serverErrors" />

                <form @submit.prevent="checkOut()">
                  <div class="card shadow border-0" v-if="cart.length">
                    <div class="card-header">
                      Order Details
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item" v-for="meal in cart">
                            {{meal.name}} - {{meal.price | currency}} * {{meal.quantity}}
                          </li>
                        </ul>

                        <div class="card-body text-muted">
                          Total: {{ cartTotal | currency }}
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                      <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" rows="2" v-model="address"></textarea>
                      </div>

                      <loading-button
                              loading-text="Processing..."
                              button-text="Checkout"
                              :is-loading="submitting"
                      ></loading-button>
                    </div>
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

  import MealComponent from "@/frontend/components/MealComponent"
  import LoadingButton from "@/components/LoadingButton";
  import * as types from "@/store/constant"
  import PopupMixins from "@/mixins/PopupMixins";

export default {
  name: "Home.vue",

  components: {
    MealComponent,
    LoadingButton
  },

  mixins: [PopupMixins],

  data() {
    return {
      meals: [],
      cart: [],
      address: '',

      serverErrors: null,
      submitting: false
    };
  },

  computed: {
      cartTotal () {
        return this.cart.reduce((total, meal) => total + meal.price * meal.quantity, 0)
      }
  },

  created() {
    this.getMeals()
  },

  methods: {
    getMeals() {
      this.$http.get(types.MEAL_API).then((resp) => {
          this.meals = resp.data.data.meals.data
      })
      .catch((err) => {

      })
    },

    checkOut() {
      this.submitting = true;
      this.serverErrors = null;

      const order = {
        cart: this.cart,
        total_amount: this.cartTotal,
        address: this.address
      };

      this.$http.post(types.CHECKOUT_API, order).then((resp) => {
        this.cart = [];
        this.address = '';
        this.$_flashSuccess(resp.data.message);
        this.submitting = false;
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

      })
    },

    updateCart(meal) {

      if (!this.$store.getters.userIsAuthenticated) {
        this.$router.push({ name: "login" });
        return;
      }

      if(meal.units > 0) {

        const cartItem = this.cart.find(item => item.id === meal.id);

        if(!cartItem) {
          this.cart.push({
            meal_id: meal.id,
            price: meal.price,
            name: meal.name,
            quantity: 1
          })
        } else {
          cartItem.quantity++
        }

        this.decreaseUnits(meal)
      }
    },

    decreaseUnits (meal) {
      meal.units--
    }
  }
};
</script>

<style lang="scss" scoped>

  .food_menu {
    padding-top: 100px;
  }


</style>
