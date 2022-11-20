function request(url, method, data) {

    url = 'http://127.0.0.1:8000' + url;

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
}

//добавить для логина и регистрации

export function auth(username, password) {
    return request('/login', 'POST', {username, password})
}

export function signup(login, email, password) {
    return request('/signup', 'POST', {login, email, password})
}

export function me() {
    return request('/me', 'GET')
}

export function getBoards() {
    return request('/boards', 'GET')
}

export function createBoard(title) {
    return request('/boards', 'POST', {title});
}

export function editBoard(id, title) {
    return request(`/boards/${id}`, 'PUT', {title});
}

export function removeBoard(id) {
    return request(`/boards/${id}`, 'DELETE');
}

export function createTaskList(boardId, title) {
    return request(`/task-lists`, 'POST', {boardId, title});
}

export function editTaskList(id, title) {
    return request(`/task-lists/${id}`, 'PUT', {title});
}

export function removeTaskList(id) {
    return request(`/task-lists/${id}`, 'DELETE');
}

export function createTasks(taskListId, text
) {
    return request(`/tasks`, 'POST', {taskListId, text});
}

export function editTask(id, text) {
    return request(`/tasks/${id}`, 'PUT', {text});
}

export function taskDone(id, isDone) {
    return request(`/tasks/${id}`, 'PUT', {isDone});
}

export function removeTask(id) {
    return request(`/tasks/${id}`, 'DELETE');
}


