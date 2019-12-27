<template>
  <b-button
    :type="buttonType"
    :variant="variant"
    :disabled="isLoading || isDisabled"
    v-bind="$attrs"
    v-on="$listeners"
    data-loading-button
    dusk="submit-checkout"
  >
    <b-spinner small type="grow" v-if="isLoading" data-loading-icon></b-spinner>
    <span v-if="isLoading">{{loadingText}}</span>

    <span v-if="!isLoading">
      <slot>{{buttonText}}</slot>
    </span>
  </b-button>
</template>

<script>
export default {
  name: "LoadingButton",
  props: {
    loadingText: {
      type: String,
      default: "Saving..."
    },
    buttonType: {
      type: String,
      default: "submit"
    },
    buttonText: {
      type: String,
      default: "Save"
    },
    variant: {
      type: String,
      default: "primary"
    },
    isLoading: {
      type: Boolean,
      default: false
    },
    isDisabled: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style>
</style>
