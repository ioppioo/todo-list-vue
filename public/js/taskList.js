//удаление списка задач

document.querySelectorAll('.js-note-remove')
    .forEach(button => {
        button.addEventListener('click', onTaskListRemove)
    });

function onTaskListRemove(event) {
    const button = event.target;
    const taskList = button.closest('.note');
    // const board = taskList.parentNode;
    const id = taskList.dataset.taskListId;
    window.api
        .removeTaskList(id)
        .then(response => {
            if (!response.ok) {
                board.appendChild(taskList);
            }
        })
        .catch(reason => {
            console.error(reason);
        });
    taskList.remove();
}

//отрисовка конпки создания задачи