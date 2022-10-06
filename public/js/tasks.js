//удаление задачи

document.querySelectorAll('.js-task-remove')
    .forEach(button => {
        button.addEventListener('click', onTaskRemove)
    });

function onTaskRemove(event) {
    const button = event.target;
    const task = button.closest('.tasks__task');
    const taskList = task.parentNode;
    const id = task.dataset.taskId;
    window.api
        .removeTask(id)
        .then(response => {
            if (!response.ok) {
                taskList.appendChild(task);
            }
        })
        .catch(reason => {
            console.error(reason);
        });
    task.remove();
}
