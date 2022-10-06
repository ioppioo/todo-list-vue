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

    editBoard(id, title) {
        return api.request(`/boards/${id}`, 'PUT', {title});
    },

    removeBoard(id) {
        return api.request(`/boards/${id}`, 'DELETE');
    },


    removeTaskList(taskListId) {
        return api.request(`/task-lists/${taskListId}`, 'DELETE');
    },

    editTask(id, title) {
        return api.request(`/tasks/${id}`, 'PUT', {title});
    },

    removeTask(id) {
        return api.request(`/tasks/${id}`, 'DELETE');
    },

    loadBoards(id, title) {
        return api.request('/boards', 'GET', {title});
    },

};
