<template>
  <div>
    <div
      v-if="value"
    >

      <b-alert :show="errorIsPresent" variant="danger" dismissible fade>
        <p v-for="error in value">
          {{error}}
        </p>
      </b-alert>

    </div>

  </div>
</template>

<script>
  export default {
    name: "ValidationErrorsDisplay",

    props: {
      value: {}
    },

    computed: {
      errorIsPresent() {
        return !!(this.value);
      }
    }
  };
</script>

<style lang="scss" scoped>
  p {
    margin: 2px;
    font-size: 14px;
  }
</style>
