<template>
  <!-- Large Modal hidden -->
  <div
    style="background-color: rgba(0, 0, 0, 0.6)"
    :class="{ hidden: !show }"
    class="flex overflow-x-hidden fixed inset-0 z-50 justify-center items-center md:inset-0 h-full"
  >
    <div
      :class="[
        { 'max-w-md': size === 'sm' },
        { 'max-w-lg': size === 'md' },
        { 'max-w-4xl': size === 'lg' },
        { 'max-w-6xl': size === 'xl' },
        { 'max-w-7xl': size === '2xl' },
      ]"
      class="animate__animated animate__slideInDown relative flex md:block items-center justify-center md:px-4 w-full h-full md:h-auto"
    >
      <!-- Modal content -->
      <div
        class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-11/12 md:w-full"
      >
        <!-- Modal header -->
        <div
          class="flex justify-between items-center p-5 rounded-t dark:border-gray-600"
        >
          <h3 class="text-xl font-medium text-gray-900 dark:text-white">
            {{ title }}
          </h3>
          <slot v-if="!title" name="header" />
          <button @click="$emit('close')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <component
          :is="isForm ? 'form' : 'div'"
          @submit.prevent="$emit('submit')"
        >
          <div class="px-6 md:py-1">
            <slot />
          </div>
          <!-- Modal footer -->
          <div
            v-if="showButtonGroup"
            class="flex items-center justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600"
          >
            <form-button
              v-if="showButton"
              type="submit"
              class="items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
              :busy="busy"
              :disabled="busy"
              @click="$emit('save')"
            >
              {{ saveTitle }}
            </form-button>
            <form-button
              class="items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
              @click="$emit('close')"
            >
              Close
            </form-button>
          </div>
        </component>
      </div>
    </div>
  </div>
</template>

<script>
import FormButton from '../common/FormButton.vue'
export default {
  components: { FormButton },
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    showButtonGroup: {
      type: Boolean,
      default: true,
    },
    showButton: {
      type: Boolean,
      default: true,
    },
    isForm: {
      type: Boolean,
      default: false,
    },
    busy: {
      type: Boolean,
      default: false,
    },
    size: {
      type: String,
      default: 'md',
    },
    title: {
      type: String,
      default: '',
    },
    saveTitle: {
      type: String,
      default: 'Save',
    },
  },
}
</script>
