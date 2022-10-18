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

    createTaskList(boardId, title) {
        return api.request(`/task-lists`, 'POST', {boardId, title});
    },

    editTaskList(id, title) {
        return api.request(`/task-lists/${id}`, 'PUT', {title});
    },

    removeTaskList(id) {
        return api.request(`/task-lists/${id}`, 'DELETE');
    },

    createTasks(taskListId, text) {
        return api.request(`/tasks`, 'POST', {taskListId, text});
    },

    editTask(id, text) {
        return api.request(`/tasks/${id}`, 'PUT', {text});
    },

    taskDone(id, isDone) {
        return api.request(`/tasks/${id}`, 'PUT', {isDone});
    },

    removeTask(id) {
        return api.request(`/tasks/${id}`, 'DELETE');
    },

};
