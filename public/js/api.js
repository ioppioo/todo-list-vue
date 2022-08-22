window.api = {
    request(url, method, data) {
        return fetch(url, {
            method,
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data),
        });
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

    deleteBoard(id, title) {
        return api.request(`/boards/${id}`, 'DELETE', {title})
    }
};
