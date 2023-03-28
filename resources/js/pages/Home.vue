<template>
   <div class="container mx-auto p-6 bg-gray-300 border border-gray-200 rounded-lg shadow overflow-y-scroll">
     <h1 class="text-2xl font-bold mb-4">Kanban</h1>
     <button @click="showFormModal = !showFormModal"  class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
       Create Task
       <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
     </button>
     <Kanban @show-edit-modal="showEditModal" :stages="stages" :blocks="taskList"></Kanban>
      <FormModal is-form show-button show-button-group save-title="Save" title="Create Task" :show="showFormModal" @save="submit" @close="showFormModal = !showFormModal">
        <div v-if="errorMessage" class="text-red-500 py-2 font-semibold">
          <span>{{ errorMessage }}</span>
        </div>
          <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">Title</label>
            <input v-model="form.title" type="text" id="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="name@flowbite.com" required>
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
   </div>
</template>

<script>
import Kanban from '../components/Kanban';
import FormModal from "../components/common/FormModal";
import {mapActions, mapState} from "vuex";
export default {
  components: {
    Kanban,
    FormModal
  },
  data() {
    return {
      stages: ['TODO', 'IN-PROGRESS', 'DONE'],
      showFormModal: false,
      isUpdate: false,
      form: {
        title: '',
        description: '',
        due_date: '',
        taskId: '',
      }
    }
  },
  computed: {
    ...mapState('task', ['tasks', 'errors']),
    taskList() {
      return this.tasks.map((e) => {
        return {
          id: e.id,
          status: this.stages[e.status],
          title: e.title,
          description: e.description,
          due_date: e.due_date
        }
      })
    },
    errorMessage() {
      return this.errors ?? null
    }
  },
  mounted() {
    this.fetchTasks()
  },
  methods: {
    ...mapActions('task', ['fetch_tasks', 'create_task', 'update_task']),
    showEditModal(id) {
      this.isUpdate = true
      const task = this.taskList.find((e) => e.id === id)
      const form = this.form
      form.title = task.title
      form.description = task.description
      form.due_date = task.due_date
      form.taskId = task.id
      this.showFormModal = !this.showFormModal
    },
    fetchTasks() {
      this.fetch_tasks()
    },
    submit(){
      if(!this.isUpdate) {
        this.create_task(this.form)
      } else {
        this.update_task(this.form)
      }
      this.fetch_tasks()
      // this.showFormModal = !this.showFormModal
    }
  }
  }
</script>
