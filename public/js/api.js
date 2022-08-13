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

    getBoardsList(id, title) {
        return api.request('/boards', 'GET', {id}, {title});
    },

    editBoard(id, title) {
        return api.request('/boards/${id}', 'PUT', {title});
    },
};