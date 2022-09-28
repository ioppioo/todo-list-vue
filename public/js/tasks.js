//отрисовка кнопки удаления

function createButtonRemove() {
    let createButtonRemove = document.createElement('button');
    createButtonRemove.className = 'button button-board-remove js-board-remove';
    createButtonRemove.innerText = '🞫';

    return createButtonRemove;
}

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

//удаление доски

document.querySelectorAll('.js-board-remove')
    .forEach(button => {
        button.addEventListener('click', onBoardRemove)
    });

function onBoardRemove(event) {
    const button = event.target;
    const board = button.closest('.board');
    const id = board.dataset.boardId;
    window.api
        .removeBoard(id)
    // .then(response => {
    //     if (!response.ok) {
    //         // board.appendChild();
    //     }
    // })
    // .catch(reason => {
    //     console.error(reason);
    // });
    board.remove();
}

//редактирование заголовка доски

document.querySelectorAll('.js-board-edit')
    .forEach(button => {
        button.addEventListener('click', onBoardEditTitle)
    });

function onBoardEditTitle(event) {
    const button = event.target;
    const input = event.target;
    const board = button.closest('.board');
    const id = board.dataset.boardId;
    const title = input.value;
    window.api
        .editBoard(id, title)
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
    editButton.className = 'button button-edit js-board-edit';
    editButton.innerText = '✎';

    return editButton;
}

// для работы с заголовком

function createEditTitleButton() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);
    // saveNotes();

    return button;
}

function createTitleText(event) {
    event.stopPropagation();
    let note = event.target.parentElement;
    replaceTitleWithInput(note);
}

// заменяем текущий заголовок заметки полем ввода

function replaceTitleWithInput(title) {
    let titleText = title.querySelector('.board-title-text');
    let styles = window.getComputedStyle(titleText);
    let rows = (titleText.getBoundingClientRect().height / parseInt(styles.lineHeight));
    const oldTitle = titleText.innerText;
    let input = createTitleInput(oldTitle, rows, (newTitle) => {
        api.editBoard(1, newTitle)
            .catch((reason) => {
                console.error(reason);
                const titleText = title.querySelector('.board-title-text');
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
    let link = document.createElement('a');
    // link.setAttribute('href', '/boards/{{ board.id }}');
    let titleText = document.createElement('span');
    titleText.className = 'board-title-text';
    titleText.innerText = text.trim();

    link.appendChild(titleText);

    return link;
}

function replaceTitleWithInputText(input) {
    let newText = input.value;
    let title = input.parentElement;
    if (newText.trim() === '') {
        title.closest('.board').remove();
    }
    else {
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

// добавляем кнопку удаления доски для каждой новой доски
let boards = document.querySelectorAll('.board');
for (let button of boards) {
    button.appendChild(createButtonRemove());
}

//добавление новой доски
function createNewBoard() {
    let newNote = document.querySelector('.boards-board-new');
    let divNote = document.createElement('div');
    // let color = replaceNoteColor();

    divNote.classList.add('board');
    divNote.dataset.boardId = "{{ board.id }}";
    // divNote.classList.toggle(color);

    newNote.after(divNote);
    divNote.append(createButtonRemove());

// добавляем заголовок доски


    let titleNote = document.createElement('div');
    titleNote.classList.add('board-title');
    let titleInput = createTitleInput('', 1, () => {
        api.saveBoards();
    });


    titleNote.appendChild(titleInput);
    divNote.appendChild(titleNote);

    titleInput.focus();
}

// добавление новой заметки

function createNoteButton() {
    let newNoteButton = document.querySelector('.boards-board-new');
    newNoteButton.onclick = function (event) {
        let note = event.target.parentElement;
        createNewBoard(note);
    }

    return newNoteButton;
}

createNoteButton();

// цвет новой заметки

function replaceNoteColor() {
    let colors = [
        'board--indianred',
        'board--lavender',
        'board--antiquewhite',
        'board--teal',
    ];

    let randomIndex = Math.floor(Math.random() * colors.length);

    return colors[randomIndex];
}


//создание массива объектов

function createTodos() {
    let todoList = [];
    let todos = document.querySelectorAll('.board');

    for (const todo of todos) {
        const note = {
            color: todo.classList[1],
            title: todo.querySelector('.board-title-text').innerText.trim()
        }
        todoList.push(note);
    }

    return todoList;
}

//сохранение бордов в JSON

// function saveNotes () {
//     localStorage.setItem('todos', JSON.stringify(createTodos()));
// }

let saveBoard;
if (saveBoard) {
    saveBoard.forEach();
}

// let saveBoard;
// if (saveBoard) {
//     saveBoard.forEach(loadNote);
// }

//загрузка бордов из JSON

let savedNotes = JSON.parse(localStorage.getItem('todos'));
if (savedNotes) {
    savedNotes.forEach(loadNote);
}

// загрузка из localstorage

function loadNote(note) {

    // создаем заметку
    let newNote = document.querySelector('.boards-board-new');
    let divNote = document.createElement('div');

    // подгружаем цвет заметки
    divNote.classList.add('note');
    divNote.classList.toggle(note.color);

    // добавляем заголовок заметки
    let titleNote = document.createElement('div');
    titleNote.classList.add('board-title');

    let titleText = createEditNewTitleText(note.title);
    titleNote.appendChild(titleText);
    titleNote.append(createEditTitleButtonToLocal())

    newNote.after(divNote);
    divNote.append(createButtonRemove());
    divNote.appendChild(titleNote);
}

function createEditTitleButtonToLocal() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);

    return button;
}
