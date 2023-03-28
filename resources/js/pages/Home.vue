<template>
   <div class="container mx-auto">
     <h1 class="text-2xl font-bold mb-4">Tasks</h1>
     <Kanban :stages="stages" :blocks="taskList"></Kanban>
   </div>
</template>

<script>
import Kanban from '../components/Kanban';

export default {
  components: {
    Kanban,
  },
  data() {
    return {
      tasks: [],
      stages: ['TODO', 'IN-PROGRESS', 'DONE'],
    }
  },
  computed: {
    taskList() {
      return this.tasks.map((e) => {
        return {
          id: e.id,
          status: this.stages[e.status],
          title: e.title,
          description: e.description,
        }
      })
    }
  },
  mounted() {
    this.fetchTasks()
  },
  methods: {
    fetchTasks() {
      axios.get('/api/tasks')
        .then(response => {
          this.tasks = response.data
        })
    }
  }
  }
</script>
