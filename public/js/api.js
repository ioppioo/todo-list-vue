window.api = {
    request(url, method, data) {
        const params = {
            method,
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        };

        if (data) {
            params.body = JSON.stringify(data);
        }

        return fetch(url, params);
    },

    createBoard(title) {
        return api.request('/boards', 'POST', {title});
    },

    editBoard(id, title) {
        return api.request(`/boards/${id}`, 'PUT', {title});
    },

    removeBoard(id) {
        return api.request(`/boards/${id}`, 'DELETE');
    },

    createTaskList(title) {
        return api.request(`/task-lists`, 'POST', {title});
    },

    editTaskList(id, title) {
        return api.request(`/task-lists/${id}`, 'PUT', {title});
    },

    removeTaskList(id) {
        return api.request(`/task-lists/${id}`, 'DELETE');
    },

   createTasks(task) {
        return api.request(`/tasks`, 'POST', {task});
    },

    editTask(id, task) {
        return api.request(`/tasks/${id}`, 'PUT', {task});
    },

    taskDone(id) {
        return api.request(`/tasks/${id}`, 'POST');
    },

    removeTask(id) {
        return api.request(`/tasks/${id}`, 'DELETE');
    },

};
