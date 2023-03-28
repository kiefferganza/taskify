import { createStore } from "vuex";
import auth from "@/js/stores/auth.module";
import task from "@/js/stores/task.module";
const store = createStore({
  modules: {
      auth,
      task: {
          ...task,
          namespaced: true
      }
  }
});

export default store;
