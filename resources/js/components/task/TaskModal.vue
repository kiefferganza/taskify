<template>
  <FormModal is-form show-button show-button-group save-title="Save" :title="isUpdate ? 'Update Task' : 'Create Task'" :show="showFormModal" @save="submit" @close="showFormModal = !showFormModal">
    <div v-if="errorMessage">
      <div v-for="(field, k) in errorMessage" :key="k" class="bg-red-500 text-white font-bold mb-4 shadow-lg py-2 px-4 pr-0">
        <p v-for="error in field" :key="error" class="text-sm">
          {{ error }}
        </p>
      </div>
    </div>

    <div class="mb-6">
      <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">Title</label>
      <input v-model="form.title" type="text" id="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Title" required>
    </div>
    <div class="mb-6">
      <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
      <textarea v-model="form.description" type="text" id="description" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
    </div>
    <div class="mb-6">
      <label for="due-date" class="block mb-2 text-sm font-medium text-gray-900">Due Date</label>
      <input v-model="form.due_date" type="date" id="due-date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
    </div>
  </FormModal>
</template>

<script>
import FormModal from "../common/FormModal";

export default {
  components: {
    FormModal
  },
  props: {
    showFormModal: {
      type: Boolean,
      default: false
    },
    updateData: {
      type: Object,
      default: null
    },
    isUpdate: {
      type: Boolean,
      default: false
    },
    errorMessage: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      form: {
        title: '',
        description: '',
        due_date: '',
        id: '',
      }
    }
  },
watch: {
  showFormModal() {
    const updateData = this.updateData
    const form = this.form
    form.title = updateData.title
    form.description = updateData.description
    form.due_date = updateData.due_date
    form.id = updateData.id
  },
  updateData(newData) {
    console.log(newData)

  }
},
  methods: {
    submit() {
      this.$emit('submit-form', {form: this.form, isUpdate: this.isUpdate})
    }
  }
}
</script>
