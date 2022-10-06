//редактирование заголовка доски

document.querySelectorAll('.js-task-list-edit')
    .forEach(button => {
        button.addEventListener('click', onTaskListTitleEdit)
    });

function onTaskListTitleEdit(event) {
    const button = event.target;
    const input = event.target;
    const taskLists = button.closest('.note');
    const id = taskLists.dataset.taskListId;
    const title = input.value;
    window.api
        .editTaskList(id, title)
        .then((response) => {
            console.log(response);
        })
        .catch(reason => {
            console.error(reason);
        });
}

// создаем кнопку редактирования

function createEditButton() {
    let editButton = document.createElement('button');
    editButton.className = 'button button-edit js-task-list-edit';
    editButton.innerText = '✎';

    return editButton;
}

// для работы с заголовком

function createEditTitleButton() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);

    return button;
}

function createTitleText(event) {
    event.stopPropagation();
    let note = event.target.parentElement;
    replaceTitleWithInput(note);
}

// заменяем текущий заголовок заметки полем ввода

function replaceTitleWithInput(title) {
    let titleText = title.querySelector('.title-note-text');
    let styles = window.getComputedStyle(titleText);
    let rows = (titleText.getBoundingClientRect().height / parseInt(styles.lineHeight));
    const oldTitle = titleText.innerText;
    let input = createTitleInput(oldTitle, rows, (newTitle) => {
        api.editTaskList(11, newTitle)
            .catch((reason) => {
                console.error(reason);
                const titleText = title.querySelector('.title-note-text');
                titleText.innerHTML = oldTitle;
            });
    });
    title.innerHTML = '';
    title.appendChild(input);
    input.focus();
}

// создаем новый текст заголовка

function createTitleInput(text, rows, handler) {
    let input = createInput(text, rows);
    input.onblur = () => {
        handler(input.value);
        replaceTitleWithInputText(input);
    };

    return input;
}

function createEditNewTitleText(text) {
    let titleText = document.createElement('span');
    titleText.className = 'title-note-text';
    titleText.innerText = text.trim();

    return titleText;
}

function replaceTitleWithInputText(input) {
    let newText = input.value;
    let title = input.parentElement;
    if (newText.trim() === '') {
        title.closest('.note').remove();
    } else {
        title.innerHTML = '';
        title.appendChild(createEditNewTitleText(newText));
        title.appendChild(createEditTitleButton());
    }
}

//создаем поле ввода

function createInput(text, rows) {
    let input = document.createElement('textarea');
    input.value = text;
    input.rows = rows;
    input.classList.add('input');

    return input;
}

// добавляем кнопку удаления для списка задач

let taskLists = document.querySelectorAll('.note');
for (let button of taskLists) {
    button.appendChild(createButtonRemove());
}

//добавление нового списка задач

function createTaskList() {
    let newTaskList = document.querySelector('.new-note');
    let divNote = document.createElement('div');
    // let color = replaceNoteColor();

    divNote.classList.add('note');
    divNote.dataset.taskListId = "{{ taskList.id }}";
    // divNote.classList.toggle(color);

    newTaskList.after(divNote);
    // divNote.append(createButtonRemove());

// добавляем заголовок списка задач

    let titleNote = document.createElement('div');
    titleNote.classList.add('title-note');
    let titleInput = createTitleInput('', 1, (title) => {
        api.saveTaskList(1, title)
            .catch((reason) => {
                console.log(reason);
            });
    });

    titleNote.appendChild(titleInput);
    divNote.appendChild(titleNote);

    titleInput.focus();

// задачи

    let olNote = document.createElement('ol');
    olNote.classList.add('tasks');
    divNote.append(olNote);
}

// добавление нового списка задач

function createTaskListButton() {
    let newTaskListButton = document.querySelector('.new-note');
    newTaskListButton.onclick = function (event) {
        let note = event.target.parentElement;
        createTaskList(note);
    }

    return newTaskListButton;
}

createTaskListButton();

// цвет списка задач

// function replaceNoteColor() {
//     let colors = [
//         'board--indianred',
//         'board--lavender',
//         'board--antiquewhite',
//         'board--teal',
//     ];
//
//     let randomIndex = Math.floor(Math.random() * colors.length);
//
//     return colors[randomIndex];
// }

//удаление списка задач

document.querySelectorAll('.js-note-remove')
    .forEach(button => {
        button.addEventListener('click', onTaskListRemove)
    });

function onTaskListRemove(event) {
    const button = event.target;
    const taskList = button.closest('.note');
    const board = taskList.parentNode;
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
