<template>
  <div>
    <div id="nav">
      <div class="container">

        <b-navbar toggleable="lg" type="dark">
          <b-navbar-brand href="#">Restaurant</b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav>

            <b-navbar-nav class="ml-auto">

              <b-nav-item href="#"
                :to="{name: 'orders.index'}"
                >
                Orders
              </b-nav-item>

              <b-nav-item href="#"
                :to="{name: 'deliveries.index'}"
                v-if="$store.getters.userIsDriver">
                Deliveries
              </b-nav-item>

              <b-nav-item href="#"
                :to="{name: 'inventory.index'}"
                v-if="$store.getters.userIsAdmin">
                Inventory
              </b-nav-item>


              <b-nav-item @click.prevent="logOut()">Logout</b-nav-item>

            </b-navbar-nav>

          </b-collapse>
        </b-navbar>

      </div>
    </div>


    <router-view></router-view>

  </div>
</template>

<script>
import * as types from "@/store/constant";

export default {
  name: "AdminLayout",

  methods: {

    logOut() {
      this.$store
              .dispatch(types.AUTH_LOGOUT)
              .then(() => {
                window.location.assign(window.location.origin)
              })
              .catch(error => {});
    }
  }
};
</script>

<style lang="scss" scoped>
  #nav {
    background-color: #2F3747;
    .navbar {
      padding-left: 0;
      padding-right: 0;

      a {
        &.router-link-exact-active:not(.uk-logo) {
          color: #fff;
        }
      }

    }
  }
</style>
