<template>
  <button
    v-bind="$attrs"
    class="text-white font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center"
    v-on="$listeners"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    busy: {
      type: Boolean,
      default: false,
    },
  },
}
</script>
