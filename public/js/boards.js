let currentBoardId = 1;

function onEditBoardTitle(event) {
    const input = event.target;
    const title = input.value;
    api.editBoard(currentBoardId, title)
        .then((response) => {
            console.log(response);
        })
        .catch(reason => {
            console.error(reason);
        });
}

// input.onblur = onEditBoardTitle;

// создаем кнопку редактирования

function createEditButton() {
    let editButton = document.createElement('button');
    editButton.className = 'button edit-button';
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
        api.editBoard(23, newTitle)
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
    let titleText = document.createElement('span');
    titleText.classList.add('board-title-text');
    titleText.innerText = text.trim();

    return titleText;
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

// добавляем кнопку удаления доски

let notes = document.querySelectorAll('.board');

for (let button of notes) {
    button.appendChild(createDelButton());
}

// добавляет новую заметку

function createNewNote() {
    let newNote = document.querySelector('.boards-board-new');
    let divNote = document.createElement('div');
    let color = replaceNoteColor();

    divNote.classList.add('board');
    divNote.classList.toggle(color);

    newNote.after(divNote);
    divNote.append(createDelButton());

// добавляем заголовок новой заметки
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
        createNewNote(note);
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

// кнопка удаления заметки

function createDelButton() {
    let createDelButton = document.createElement('button');
    createDelButton.className = 'button button-task-del';
    createDelButton.innerText = '🞫';
    createDelButton.onclick = function () {
        createDelButton.parentElement.remove();

        api.deleteBoard(23, title);
    }

    return createDelButton;
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
    divNote.append(createDelButton());
    divNote.appendChild(titleNote);
}

function createEditTitleButtonToLocal() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);

    return button;
}