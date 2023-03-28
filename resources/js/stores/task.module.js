export const state = {
    tasks: [],
    errors: null,
};

export const actions = {
    ['fetch_tasks'](context) {
        return axios.get('/api/tasks')
            .then((response) => {
                context.commit('setTasks', response.data)
            })
            .catch((error) => {
                this.errors = error.response.data.errors
                context.commit('updateUser', null);
                throw error
            })
    },
    ['create_task']({commit}, payload) {
        console.log(payload)
        return axios.post('/api/tasks', {
                    title: payload.title,
                    description: payload.description,
                    due_date: payload.due_date,
        })
            .then((response) => {
                commit('createTask', response.data)
                return response
            })
            .catch((error) => {
                commit('setErrors', error.response.data.message);
                throw error
            })
    },
    ['update'](context) {
        return axios.get('/api/v1/me')
            .then((response) => {
                context.commit('updateUser', response.data.data)
                return response
            })
            .catch((error) => {
                context.commit('updateUser', null);
                throw error
            })
    },
};

export const mutations = {
    setTasks: (state, task) => {
        state.tasks = task
    },
    createTask: (state, task) => {
        state.tasks.push(task)
    },
    updateTask: (state, task) => {
        state.tasks = task
    },
    setErrors: (state, errors) => {
        state.errors = errors
    }
};

export const getters = {
    ['tasks'](state) {
        return state.task
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
