<template>
   <div class="container mx-auto p-6 bg-gradient-to-tr from-blue-200 via-indigo-200 to-blue-300 border border-gray-200 rounded-lg shadow overflow-y-scroll">
     <h1 class="text-2xl font-bold mb-4">Kanban</h1>
     <button @click="showFormModal = true"
             class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
       Create Task
       <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
         <path fill-rule="evenodd"
               d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
               clip-rule="evenodd">

         </path>
       </svg>
     </button>
     <Kanban
       @show-edit-modal="showEditModal"
       :stages="stages"
       :blocks="taskList"
       @create-task="showFormModal = true"
       @update-block="updateTaskStatus">
     </Kanban>
      <TaskModal
        :show-form-modal="showFormModal"
        :is-update="isUpdate"
        :error-message="errorMessage"
        :update-data="updateData"
        @close-modal="showFormModal = false"
        @submit-form="submit"
        @delete="deleteTask"
      >

      </TaskModal>
   </div>
</template>

<script>
import Kanban from '../components/Kanban';
import TaskModal from "../components/task/TaskModal";
import {mapActions, mapState} from "vuex";
export default {
  components: {
    Kanban,
    TaskModal
  },
  data() {
    return {
      stages: ['TODO', 'IN-PROGRESS', 'DONE'],
      showFormModal: false,
      isUpdate: false,
      updateData: {},
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
      return this.errors ?? []
    }
  },
  mounted() {
    this.fetchTasks()
  },
  methods: {
    ...mapActions('task', ['fetch_tasks', 'create_task', 'update_task', 'delete_task']),
    updateTaskStatus(id, status) {
      const task = this.taskList.find((e) => e.id === Number(id))
      const payload = {
        id: task.id,
        status: this.stages.indexOf(status)
      }
      this.update_task(payload)
      this.fetch_tasks()
    },
    showEditModal(id) {
      this.isUpdate = true
      const task = this.taskList.find((e) => e.id === id)
      const updateData = this.updateData
      updateData.title = task.title
      updateData.description = task.description
      updateData.due_date = task.due_date
      updateData.id = task.id
      this.showFormModal = true
    },
    fetchTasks() {
      this.fetch_tasks()
    },
    async submit(data){
      console.log(data)
      const formData = data.form
      if(!data.isUpdate) {
        await this.create_task(formData)
      } else {
        await this.update_task(formData)
      }
      await this.fetch_tasks()
      if(this.errorMessage.length === 0) {
        this.showFormModal = false
      }
    },
    async deleteTask(id) {
      await this.delete_task(id)
      await this.fetch_tasks()
      if(this.errorMessage.length === 0) {
        this.showFormModal = false
      }
    }
  },
}
</script>
