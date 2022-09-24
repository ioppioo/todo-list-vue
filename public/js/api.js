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

    saveBoards(id, title) {
        return api.request('/boards', 'POST', {title});
    },

    loadBoards(id, title) {
        return api.request('/boards', 'GET', {title});
    },

    editBoard(id, title) {
        return api.request(`/boards/${id}`, 'PUT', {title});
    },

    editTask(id, title) {
        return api.request(`/tasks/${id}`, 'PUT', {title});
    }
    ,

    removeBoard(id) {
        return api.request(`/boards/${id}`, 'DELETE');
    },

    removeTaskList(taskListId) {
        return api.request(`/task-lists/${taskListId}`, 'DELETE');
    },

    removeTask(id) {
        return api.request(`/tasks/${id}`, 'DELETE');
    },
};
