<template>
  <div id="app">

      <header class="header-global">
          <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
              <div class="container">
                  <a class="navbar-brand mr-lg-5" href="#">
                      <img src="/front/img/brand/white.png" alt="brand">
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="navbar-collapse collapse" id="navbar_global">
                      <div class="navbar-collapse-header">
                          <div class="row">
                              <div class="col-6 collapse-brand">
                                  <a href="#">
                                      <img src="front/img/brand/blue.png" alt="brand">
                                  </a>
                              </div>
                              <div class="col-6 collapse-close">
                                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                                      <span></span>
                                      <span></span>
                                  </button>
                              </div>
                          </div>
                      </div>

                      <ul class="navbar-nav navbar-nav-hover align-items-lg-center"></ul>

                      <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                          <template v-if="$store.getters.userIsAuthenticated">
                              <li class="nav-item d-none d-lg-block ml-lg-4">
                                  <a class="btn btn-neutral btn-icon"
                                     @click.prevent="goToDashboard()">
                                      <span class="nav-link-inner--text">Dashboard</span>
                                  </a>
                              </li>
                          </template>

                          <template v-if="!$store.getters.userIsAuthenticated">
                              <li class="nav-item">
                                  <router-link
                                          class="nav-link" role="button"
                                          :to="{name: 'login'}">
                                      <span class="nav-link-inner--text">Login</span>
                                  </router-link>
                              </li>
                              <li class="nav-item">
                                  <router-link
                                          class="nav-link" role="button"
                                          :to="{name: 'register'}">
                                      <span class="nav-link-inner--text">Register</span>
                                  </router-link>
                              </li>
                          </template>
                      </ul>
                  </div>
              </div>
          </nav>
      </header>

      <router-view></router-view>

  </div>
</template>

<script>

export default {
  name: "App",

  methods: {
      goToDashboard () {
          window.location.assign(window.location.origin + '/admin/orders')
      }
  }
};
</script>

<style lang="scss" scoped>

</style>
